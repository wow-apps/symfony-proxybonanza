<?php
/**
 * This file is part of the wow-apps/symfony-proxybonanza project
 * https://github.com/wow-apps/symfony-proxybonanza
 *
 * (c) 2016 WoW-Apps
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WowApps\ProxybonanzaBundle\Repository;

use WowApps\ProxybonanzaBundle\Entity\Plan;

/**
 * Class PlanRepository
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
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
