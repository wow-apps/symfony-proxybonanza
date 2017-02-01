<?php

namespace WowApps\ProxyBonanzaBundle\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPack;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPlan;
use WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaAuthIpsRepository;
use WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaPlanRepository;
use WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaProxiesRepository;
use WowApps\ProxyBonanzaBundle\Traits\HelperTrait;

class ProxyBonanza
{
    use HelperTrait;

    /** @var array */
    private $config;

    /** @var GuzzleClient */
    private $guzzleClient;

    /** @var ProxyBonanzaPlanRepository */
    private $proxyBonanzaPlanRepository;

    /** @var ProxyBonanzaProxiesRepository */
    private $proxyBonanzaProxiesRepository;

    /** @var ProxyBonanzaAuthIpsRepository */
    private $proxyBonanzaAuthips;

    /**
     * ProxyBonanza constructor.
     * @param array $config
     * @param ProxyBonanzaPlanRepository $planRepository
     * @param ProxyBonanzaProxiesRepository $proxiesRepository
     * @param ProxyBonanzaAuthIpsRepository $authIpsRepository
     */
    public function __construct(
        array $config,
        ProxyBonanzaPlanRepository $planRepository,
        ProxyBonanzaProxiesRepository $proxiesRepository,
        ProxyBonanzaAuthIpsRepository $authIpsRepository
    ) {
        $this->setConfig($config);
        $this->proxyBonanzaPlanRepository = $planRepository;
        $this->proxyBonanzaProxiesRepository = $proxiesRepository;
        $this->proxyBonanzaAuthips = $authIpsRepository;
        $this->guzzleClient = new GuzzleClient(
            ['headers' => ['Authorization' => $this->config['api_key']]]
        );
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $url
     * @return array
     * @throws \RuntimeException
     */
    private function getAPIResponse(string $url): array
    {
        try {
            $request = $this->guzzleClient->get($url);
        } catch (ClientException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        $response = $request->getBody();

        $json = json_decode($response, true);
        if (!$json) {
            throw new \RuntimeException('Can\'t parse json');
        }

        if (!$json['success']) {
            throw new \RuntimeException('Error in response');
        }

        return $json;
    }

    /**
     * @return \ArrayObject|ProxyBonanzaPlan[]
     */
    public function getRemotePlans(): \ArrayObject
    {
        $result = new \ArrayObject();

        $proxyBonanzaPlans = $this->getAPIResponse($this->config['api_url'] . 'userpackages.json');
        if (empty($proxyBonanzaPlans['data'])) {
            return $result;
        }

        foreach ($proxyBonanzaPlans['data'] as $plan) {
            $proxyBonanzaPlan = new ProxyBonanzaPlan($plan['id']);
            $proxyBonanzaPlan
                ->setPlanId((int)$plan['id'])
                ->setPlanLogin($plan['login'])
                ->setPlanPassword($plan['password'])
                ->setPlanExpires($this->convertDateTime($plan['expires']))
                ->setPlanBandwidth($plan['bandwidth'])
                ->setPlanLastIpChange($this->convertDateTime($plan['last_ip_change']))
                ->setPlanPackageName($plan['package']['name'])
                ->setPlanPackageBandwidth($plan['package']['bandwidth'])
                ->setPlanPackagePrice((float) $plan['package']['price'])
                ->setPlanPackageHowmanyIps((int) $plan['package']['howmany_ips'])
                ->setPlanPackagePricePerGig((float) $plan['package']['price_per_gig'])
                ->setPlanPackageType($plan['package']['package_type'])
            ;

            $result->offsetSet($proxyBonanzaPlan->getPlanId(), $proxyBonanzaPlan);
        }

        return $result;
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonanzaPlans
     * @return \ArrayObject|ProxyBonanzaPlan[]
     */
    public function getRemotePacks(\ArrayObject $proxyBonanzaPlans): \ArrayObject
    {
        if (!$proxyBonanzaPlans->count()) {
            throw new \InvalidArgumentException('Can\'t get ip packs for empty plans');
        }

        /** @var ProxyBonanzaPlan $proxyBonanzaPlan */
        foreach ($proxyBonanzaPlans as $proxyBonanzaPlan) {
            $proxyBonanzaPackUrl = $this->config['api_url']
                . sprintf('userpackages/%s.json', $proxyBonanzaPlan->getPlanId());
            $proxyBonanzaPack = $this->getAPIResponse($proxyBonanzaPackUrl);
            if (empty($proxyBonanzaPack['data']['ippacks'])) {
                continue;
            }

            foreach ($proxyBonanzaPack['data']['ippacks'] as $item) {
                $ipPack = new ProxyBonanzaPack();
                $ipPack
                    ->setPackIp($item['ip'])
                    ->setPackPlan($proxyBonanzaPlan->getPlanId())
                    ->setPackLogin($proxyBonanzaPlan->getPlanLogin())
                    ->setPackPassword($proxyBonanzaPlan->getPlanPassword())
                    ->setPackPortHttp((int)$item['port_http'])
                    ->setPackPortSocks((int)$item['port_socks'])
                    ->setPackRegionId((int)$item['proxyserver']['georegion_id'])
                    ->setPackRegionCountryName($item['proxyserver']['georegion']['name'])
                ;

                $proxyBonanzaPlan->appendIpPack($ipPack);
            }

            if (empty($proxyBonanzaPack['data']['authips'])) {
                continue;
            }

            foreach ($proxyBonanzaPack['data']['authips'] as $item) {
                $proxyBonanzaPlan->appendAuthIp((int)$item['id'], $item['ip']);
            }
        }

        return $proxyBonanzaPlans;
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonanzaPlans
     */
    public function updateLocalDataFromRemote(\ArrayObject $proxyBonanzaPlans = null)
    {
        if (is_null($proxyBonanzaPlans) || !$proxyBonanzaPlans->count()) {
            $proxyBonanzaPlans = $this->getRemotePlans();
            $proxyBonanzaPlans = $this->getRemotePacks($proxyBonanzaPlans);
        }

        $this->proxyBonanzaPlanRepository->empty();
        $this->proxyBonanzaPlanRepository->insertPlans($proxyBonanzaPlans);

        $this->proxyBonanzaProxiesRepository->empty();
        $this->proxyBonanzaProxiesRepository->insertProxies($proxyBonanzaPlans);

        $this->proxyBonanzaAuthips->empty();
        $this->proxyBonanzaAuthips->insertAuthIps($proxyBonanzaPlans);
    }

    /**
     * @param int $planId
     * @return ProxyBonanzaPlan
     * @throws \InvalidArgumentException
     */
    public function getLocalPlan(int $planId): ProxyBonanzaPlan
    {
        return $this->proxyBonanzaPlanRepository->getLocalPlan($planId);
    }

    /**
     * @return \ArrayObject|ProxyBonanzaPlan[]
     * @throws \InvalidArgumentException
     */
    public function getLocalPlans(): \ArrayObject
    {
        $proxyBonanzaPlans = $this->proxyBonanzaPlanRepository->getLocalPlans();

        if (empty($proxyBonanzaPlans)) {
            throw new \InvalidArgumentException('No local plans founded. Run proxybonanza:update to set local plans.');
        }

        return $proxyBonanzaPlans;
    }

    /**
     * @param ProxyBonanzaPlan|null $proxyBonanzaPlan
     * @return \ArrayObject|ProxyBonanzaPack[]
     */
    public function getLocalProxies(ProxyBonanzaPlan $proxyBonanzaPlan = null): \ArrayObject
    {
        $proxyPlans = new \ArrayObject();
        $localProxies = $this->proxyBonanzaProxiesRepository->getLocalProxies($proxyBonanzaPlan);

        if (is_null($proxyBonanzaPlan) && !empty($localProxies)) {
            foreach ($localProxies as $localProxy) {
                if ($proxyPlans->offsetExists($localProxy->getPackPlan())) {
                    $proxyPlan = $proxyPlans->offsetGet($localProxy->getPackPlan());
                } else {
                    $proxyPlan = $this->proxyBonanzaPlanRepository->getLocalPlan($localProxy->getPackPlan());
                }

                $localProxy
                    ->setPackLogin($proxyPlan->getPlanLogin())
                    ->setPackPassword($proxyPlan->getPlanPassword())
                ;
            }
        }

        return $localProxies;
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonanzaPlans
     * @return ProxyBonanzaPack
     */
    public function getRandomProxy(\ArrayObject $proxyBonanzaPlans): ProxyBonanzaPack
    {
        $keys = $this->getArrayObjectKeys($proxyBonanzaPlans);
        return $proxyBonanzaPlans->offsetGet(array_rand($keys, 1));
    }

    /**
     * @param ProxyBonanzaPack $proxyBonanzaPack
     * @return bool
     */
    public function testProxyConnection(ProxyBonanzaPack $proxyBonanzaPack): bool
    {
        $client = new GuzzleClient();

        $proxy = [
            'http' => 'tcp://' . $proxyBonanzaPack->getPackLogin() . ':'
                . $proxyBonanzaPack->getPackPassword() . '@'
                . $proxyBonanzaPack->getPackIp() . ':'
                . $proxyBonanzaPack->getPackPortHttp(),
            'https' => 'tcp://' . $proxyBonanzaPack->getPackLogin() . ':'
                . $proxyBonanzaPack->getPackPassword() . '@'
                . $proxyBonanzaPack->getPackIp() . ':'
                . $proxyBonanzaPack->getPackPortHttp()
        ];

        $response = $client->request('GET', 'http://google.com', ['proxy' => $proxy]);

        if (!in_array($response->getStatusCode(), [200, 301, 302])) {
            return false;
        }

        return true;
    }
}
