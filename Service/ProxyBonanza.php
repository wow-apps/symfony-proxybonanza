<?php

namespace WowApps\ProxyBonanzaBundle\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPack;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPlan;
use WowApps\ProxyBonanzaBundle\Entity\ProxyBonanzaPlan as ProxyBonanzaPlanEntity;
use WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaPlanRepository;
use WowApps\ProxyBonanzaBundle\Traits\HelperTrait;

class ProxyBonanza
{
    use HelperTrait;

    /** @var array */
    private $config;

    /** @var GuzzleClient */
    private $guzzleClient;

    /**
     * ProxyBonanza constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
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

    public function updateLocalDataFromRemote()
    {
        $proxyBonanzaPlans = $this->getRemotePlans();
        $proxyBonanzaPlans = $this->getRemotePacks($proxyBonanzaPlans);
        //TODO
    }
}