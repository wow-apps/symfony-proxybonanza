<?php

namespace WowApps\ProxyBonanzaBundle\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use WowApps\ProxyBonanzaBundle\Entity\AuthIps;
use WowApps\ProxyBonanzaBundle\Entity\Plan;
use WowApps\ProxyBonanzaBundle\Entity\Proxy;
use WowApps\ProxyBonanzaBundle\Repository\AuthIpsRepository;
use WowApps\ProxyBonanzaBundle\Repository\PlanRepository;
use WowApps\ProxyBonanzaBundle\Repository\ProxiesRepository;
use WowApps\ProxyBonanzaBundle\Traits\HelperTrait;

class ProxyBonanza
{
    use HelperTrait;

    /** @var array */
    private $config;

    /** @var GuzzleClient */
    private $guzzleClient;

    /** @var PlanRepository */
    private $planRepository;

    /** @var ProxiesRepository */
    private $proxiesRepository;

    /** @var AuthIpsRepository */
    private $authIpsRepository;

    /**
     * ProxyBonanza constructor.
     * @param array $config
     * @param PlanRepository $planRepository
     * @param ProxiesRepository $proxiesRepository
     * @param AuthIpsRepository $authIpsRepository
     */
    public function __construct(
        array $config,
        PlanRepository $planRepository,
        ProxiesRepository $proxiesRepository,
        AuthIpsRepository $authIpsRepository
    ) {
        $this->setConfig($config);
        $this->planRepository = $planRepository;
        $this->proxiesRepository = $proxiesRepository;
        $this->authIpsRepository = $authIpsRepository;
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
     * @return ProxyBonanza
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
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
     * @return \ArrayObject|Plan[]
     */
    public function getRemotePlans(): \ArrayObject
    {
        $result = new \ArrayObject();

        $proxyBonanzaPlans = $this->getAPIResponse($this->config['api_url'] . 'userpackages.json');
        if (empty($proxyBonanzaPlans['data'])) {
            return $result;
        }

        foreach ($proxyBonanzaPlans['data'] as $plan) {
            $proxyBonanzaPlan = new Plan();
            $proxyBonanzaPlan
                ->setId((int)$plan['id'])
                ->setLogin($plan['login'])
                ->setPassword($plan['password'])
                ->setExpires($this->convertDateTime($plan['expires']))
                ->setBandwidth($plan['bandwidth'])
                ->setLastIpChange($this->convertDateTime($plan['last_ip_change']))
                ->setPackageName($plan['package']['name'])
                ->setPackageBandwidth($plan['package']['bandwidth'])
                ->setPackagePrice((float) $plan['package']['price'])
                ->setPackageHowmanyIps((int) $plan['package']['howmany_ips'])
                ->setPackagePricePerGig((float) $plan['package']['price_per_gig'])
                ->setPackageType($plan['package']['package_type'])
            ;

            $result->offsetSet($proxyBonanzaPlan->getId(), $proxyBonanzaPlan);
        }

        return $result;
    }

    /**
     * @param \ArrayObject|Plan[] $pbPlans
     * @return \ArrayObject|Plan[]
     */
    public function getRemotePacks(\ArrayObject $pbPlans): \ArrayObject
    {
        if (!$pbPlans->count()) {
            throw new \InvalidArgumentException('Can\'t get ip packs for empty plans');
        }

        /** @var Plan $pbPlan */
        foreach ($pbPlans as $pbPlan) {
            $pbPackUrl = $this->config['api_url'] . sprintf('userpackages/%s.json', $pbPlan->getId());

            $pbPack = $this->getAPIResponse($pbPackUrl);
            if (empty($pbPack['data']['ippacks'])) {
                continue;
            }

            foreach ($pbPack['data']['ippacks'] as $item) {
                $proxy = new Proxy();
                $proxy
                    ->setProxyId((int)$item['id'])
                    ->setProxyIp($item['ip'])
                    ->setProxyPlan($pbPlan->getId())
                    ->setPlan($pbPlan)
                    ->setProxyPortHttp((int)$item['port_http'])
                    ->setProxyPortSocks((int)$item['port_socks'])
                    ->setProxyRegionId((int)$item['proxyserver']['georegion_id'])
                    ->setProxyRegionCountryName($item['proxyserver']['georegion']['name'])
                ;

                $pbPlan->appendProxy($proxy);
            }

            if (empty($pbPack['data']['authips'])) {
                continue;
            }

            foreach ($pbPack['data']['authips'] as $item) {
                $authIp = new AuthIps();
                $authIp
                    ->setId((int)$item['id'])
                    ->setIp($item['id'])
                ;
                $pbPlan->appendAuthIp($authIp);
            }
        }

        return $pbPlans;
    }

    /**
     * @param \ArrayObject|Plan[] $pbPlans
     */
    public function updateLocalDataFromRemote(\ArrayObject $pbPlans = null)
    {
        if (is_null($pbPlans) || !$pbPlans->count()) {
            $pbPlans = $this->getRemotePlans();
            $pbPlans = $this->getRemotePacks($pbPlans);
        }

        $this->planRepository->empty();
        $this->planRepository->insertPlans($pbPlans);

        $this->proxiesRepository->empty();
        $this->proxiesRepository->insertProxies($pbPlans);

        $this->authIpsRepository->empty();
        $this->authIpsRepository->insertAuthIps($pbPlans);
    }

    /**
     * @param int $planId
     * @return Plan
     * @throws \InvalidArgumentException
     */
    public function getLocalPlan(int $planId): Plan
    {
        return $this->planRepository->getLocalPlan($planId);
    }

    /**
     * @return \ArrayObject|Plan[]
     * @throws \InvalidArgumentException
     */
    public function getLocalPlans(): \ArrayObject
    {
        $proxyBonanzaPlans = $this->planRepository->getLocalPlans();

        if (empty($proxyBonanzaPlans)) {
            throw new \InvalidArgumentException('No local plans founded. Run proxybonanza:update to set local plans.');
        }

        return $proxyBonanzaPlans;
    }

    /**
     * @param Plan|null $pbPlan
     * @return \ArrayObject|Proxy[]
     */
    public function getLocalProxies(Plan $pbPlan = null): \ArrayObject
    {
        return $this->proxiesRepository->getLocalProxies($pbPlan);
    }

    /**
     * @param \ArrayObject|Plan[] $pbPlans
     * @return \ArrayObject|Plan[]
     */
    public function getLocalPlansProxies(\ArrayObject $pbPlans): \ArrayObject
    {
        if (empty($pbPlans)) {
            return $pbPlans;
        }

        foreach ($pbPlans as $pbPlan) {
            $pbPlan->setProxy($this->getLocalProxies($pbPlan));
        }

        return $pbPlans;
    }

    /**
     * @param \ArrayObject|Proxy[] $proxies
     * @return Proxy
     */
    public function getRandomProxy(\ArrayObject $proxies): Proxy
    {
        $keys = $this->getArrayObjectKeys($proxies);
        return $proxies->offsetGet(
            $keys[array_rand($keys, 1)]
        );
    }

    /**
     * @param Proxy $proxy
     * @return bool
     */
    public function testProxyConnection(Proxy $proxy): bool
    {
        $client = new GuzzleClient();

        $proxyTCP = [
            'http' => 'tcp://' . $proxy->getPlan()->getLogin() . ':'
                . $proxy->getPlan()->getPassword() . '@'
                . $proxy->getProxyIp() . ':'
                . $proxy->getProxyPortHttp(),
            'https' => 'tcp://' . $proxy->getPlan()->getLogin() . ':'
                . $proxy->getPlan()->getPassword() . '@'
                . $proxy->getProxyIp() . ':'
                . $proxy->getProxyPortHttp(),
        ];

        $response = $client->request('GET', 'http://google.com', ['proxy' => $proxyTCP]);

        if (!in_array($response->getStatusCode(), [200, 301, 302])) {
            return false;
        }

        return true;
    }
}
