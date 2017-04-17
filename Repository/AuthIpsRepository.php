<?php

namespace Wowapps\ProxyBonanzaBundle\Repository;

use Wowapps\ProxyBonanzaBundle\Entity\Plan;
use Wowapps\ProxyBonanzaBundle\Entity\AuthIps;

class AuthIpsRepository extends AbstractRepository
{
    public function empty()
    {
        $queryBuilder = $this->pdoDB->createQueryBuilder();
        $queryBuilder->delete(AuthIps::TABLE_NAME);
        $queryBuilder->execute();
    }

    /**
     * @param \ArrayObject|Plan[] $pbPlans
     * @return bool
     */
    public function insertAuthIps(\ArrayObject $pbPlans): bool
    {
        if (!$pbPlans->count()) {
            return false;
        }

        foreach ($pbPlans as $pbPlan) {
            if (!empty($pbPlan->getAuthIps())) {
                continue;
            }

            foreach ($pbPlan->getAuthIps() as $authIp) {
                $authIp->setPlan($pbPlan->getPlanId());
                $this->entityManager->persist($authIp);
            }
        }

        $this->entityManager->flush();

        return true;
    }
}
