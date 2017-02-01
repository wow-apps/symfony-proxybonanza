<?php

namespace WowApps\ProxyBonanzaBundle\Repository;

use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPlan;
use WowApps\ProxyBonanzaBundle\Entity\ProxyBonanzaAuthIps;

class ProxyBonanzaAuthIpsRepository extends AbstractRepository
{
    public function empty()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->delete(ProxyBonanzaAuthIps::TABLE_NAME);
        $qb->execute();
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonzanaPlans
     * @return bool
     */
    public function insertAuthIps(\ArrayObject $proxyBonzanaPlans): bool
    {
        if (!$proxyBonzanaPlans->count()) {
            return false;
        }

        foreach ($proxyBonzanaPlans as $proxyBonanzaPlan) {
            if (!empty($proxyBonanzaPlan->getAuthIps())) {
                continue;
            }

            foreach ($proxyBonanzaPlan->getAuthIps() as $authIp) {
                $aiEntity = new ProxyBonanzaAuthIps();
                $aiEntity
                    ->setIp($authIp)
                    ->setPlan($proxyBonanzaPlan->getPlanId())
                ;

                $this->em->persist($aiEntity);
            }
        }

        $this->em->flush();

        return true;
    }
}
