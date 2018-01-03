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
use WowApps\ProxybonanzaBundle\Entity\Proxy;

/**
 * Class ProxiesRepository
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
class ProxiesRepository extends AbstractRepository
{
    public function empty()
    {
        $queryBuilder = $this->pdoDB->createQueryBuilder();
        $queryBuilder->delete(Proxy::TABLE_NAME);
        $queryBuilder->execute();
    }

    /**
     * @param \ArrayObject|Plan[] $pbPlans
     * @return bool
     */
    public function insertProxies(\ArrayObject $pbPlans): bool
    {
        if (!$pbPlans->count()) {
            return false;
        }

        /** @var Plan $pbPlan */
        foreach ($pbPlans as $pbPlan) {
            if (!$pbPlan->getProxy()->count()) {
                continue;
            }

            /** @var Proxy $proxy */
            foreach ($pbPlan->getProxy() as $proxy) {
                $this->entityManager->persist($proxy);
            }
        }

        $this->entityManager->flush();

        return true;
    }

    /**
     * @param Plan|null $pbPlan
     * @return \ArrayObject|Proxy[]
     */
    public function getLocalProxies(Plan $pbPlan = null): \ArrayObject
    {
        $proxies = new \ArrayObject();

        if (is_null($pbPlan)) {
            $doctrineResult = $this->findAll();
        } else {
            $doctrineResult = $this->findBy(['proxyPlan' => $pbPlan->getId()]);
        }

        /** @var Proxy $proxy */
        foreach ($doctrineResult as $proxy) {
            $proxies->offsetSet($proxy->getProxyId(), $proxy);
        }

        return $proxies;
    }
}
