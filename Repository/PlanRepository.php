<?php

namespace WowApps\ProxyBonanzaBundle\Repository;

use WowApps\ProxyBonanzaBundle\Entity\Plan;

class PlanRepository extends AbstractRepository
{
    public function empty()
    {
        $queryBuilder = $this->pdoDB->createQueryBuilder();
        $queryBuilder->delete(Plan::TABLE_NAME);
        $queryBuilder->execute();
    }

    /**
     * @param \ArrayObject|Plan[] $pbPlans
     * @return bool
     */
    public function insertPlans(\ArrayObject $pbPlans): bool
    {
        if (!$pbPlans->count()) {
            return false;
        }

        foreach ($pbPlans as $pbPlan) {
            $this->entityManager->persist($pbPlan);
        }

        $this->entityManager->flush();

        return true;
    }

    /**
     * @param int $planId
     * @return Plan
     */
    public function getLocalPlan(int $planId): Plan
    {
        /** @var Plan $pbPlan */
        $pbPlan = $this->findOneBy(['id' => $planId]);
        return $pbPlan;
    }

    /**
     * @return \ArrayObject|Plan[]
     */
    public function getLocalPlans(): \ArrayObject
    {
        $pbPlans = new \ArrayObject();

        /** @var Plan $plan */
        foreach ($this->findAll() as $plan) {
            $pbPlans->offsetSet($plan->getId(), $plan);
        }

        return $pbPlans;
    }
}
