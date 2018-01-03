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
use WowApps\ProxybonanzaBundle\Entity\AuthIps;

/**
 * Class AuthIpsRepository
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
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
