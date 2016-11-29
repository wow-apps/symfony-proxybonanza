<?php

namespace WowApps\ProxyBonanzaBundle\Repository;

use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPack;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPlan;
use WowApps\ProxyBonanzaBundle\Entity\ProxyBonanzaProxies;

class ProxyBonanzaProxiesRepository extends AbstractRepository
{
    public function empty()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->delete(ProxyBonanzaProxies::TABLE_NAME);
        $qb->execute();
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonzanaPlans
     * @return bool
     */
    public function insertProxies(\ArrayObject $proxyBonzanaPlans): bool
    {
        if (!$proxyBonzanaPlans->count()) {
            return false;
        }

        /** @var ProxyBonanzaPlan $proxyBonanzaPlan */
        foreach ($proxyBonzanaPlans as $proxyBonanzaPlan) {
            if (!$proxyBonanzaPlan->getIppacks()->count()) {
                continue;
            }

            /** @var ProxyBonanzaPack $ipPack */
            foreach ($proxyBonanzaPlan->getIppacks() as $ipPack) {
                $proxyBonanzaProxyEntity = new ProxyBonanzaProxies();
                $proxyBonanzaProxyEntity
                    ->setProxyPlan($proxyBonanzaPlan->getPlanId())
                    ->setProxyIp($ipPack->getPackIp())
                    ->setProxyPortHttp($ipPack->getPackPortHttp())
                    ->setProxyPortSocks($ipPack->getPackPortSocks())
                    ->setProxyRegionId($ipPack->getPackRegionId())
                    ->setProxyRegionName($ipPack->getPackRegionName())
                    ->setProxyRegionCountryName($ipPack->getPackRegionCountryName())
                ;

                $this->em->persist($proxyBonanzaProxyEntity);
            }
        }

        $this->em->flush();

        return true;
    }
}
