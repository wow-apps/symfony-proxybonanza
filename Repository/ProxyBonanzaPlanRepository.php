<?php

namespace WowApps\ProxyBonanzaBundle\Repository;

use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPlan as ProxyBonanzaPlanDTO;
use WowApps\ProxyBonanzaBundle\Entity\ProxyBonanzaPlan;

class ProxyBonanzaPlanRepository extends AbstractRepository
{
    public function empty()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->delete(ProxyBonanzaPlan::TABLE_NAME);
        $qb->execute();
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPlanDTO[] $proxyBonzanaPlans
     * @return bool
     */
    public function insertPlans(\ArrayObject $proxyBonzanaPlans): bool
    {
        if (!$proxyBonzanaPlans->count()) {
            return false;
        }

        foreach ($proxyBonzanaPlans as $proxyBonanzaPlan) {
            $proxyBonanzaPlanEntity = new ProxyBonanzaPlan();
            $proxyBonanzaPlanEntity
                ->setPlanId($proxyBonanzaPlan->getPlanId())
                ->setPlanLogin($proxyBonanzaPlan->getPlanLogin())
                ->setPlanPassword($proxyBonanzaPlan->getPlanPassword())
                ->setPlanExpires($proxyBonanzaPlan->getPlanExpires())
                ->setPlanBandwidth($proxyBonanzaPlan->getPlanBandwidth())
                ->setPlanLastIpChange($proxyBonanzaPlan->getPlanLastIpChange())
                ->setPlanPackageName($proxyBonanzaPlan->getPlanPackageName())
                ->setPlanPackageBandwidth($proxyBonanzaPlan->getPlanPackageBandwidth())
                ->setPlanPackagePrice($proxyBonanzaPlan->getPlanPackagePrice())
                ->setPlanPackageHowmanyIps($proxyBonanzaPlan->getPlanPackageHowmanyIps())
                ->setPlanPackagePricePerGig($proxyBonanzaPlan->getPlanPackagePricePerGig())
                ->setPlanPackageType($proxyBonanzaPlan->getPlanPackageType())
            ;

            $this->em->persist($proxyBonanzaPlanEntity);
        }

        $this->em->flush();

        return true;
    }

    /**
     * @param int $planId
     * @return ProxyBonanzaPlanDTO
     */
    public function getLocalPlan(int $planId): ProxyBonanzaPlanDTO
    {
        $plan = $this->findOneBy(['planId' => $planId]);
        $proxyBonanzaPlanDTO = $this->convertEntity2DTO($plan[$planId]);

        return $proxyBonanzaPlanDTO;
    }

    /**
     * @return \ArrayObject|ProxyBonanzaPlanDTO[]
     */
    public function getLocalPlans(): \ArrayObject
    {
        $proxyBonanzaPlans = new \ArrayObject();

        /** @var ProxyBonanzaPlan $plan */
        foreach ($this->findAll() as $plan) {
            $proxyBonanzaPlanDTO = $this->convertEntity2DTO($plan);
            $proxyBonanzaPlans->offsetSet($proxyBonanzaPlanDTO->getPlanId(), $proxyBonanzaPlanDTO);
        }

        return $proxyBonanzaPlans;
    }

    /**
     * @param ProxyBonanzaPlan $proxyBonanzaPlan
     * @return ProxyBonanzaPlanDTO
     */
    private function convertEntity2DTO(ProxyBonanzaPlan $proxyBonanzaPlan): ProxyBonanzaPlanDTO
    {
        $proxyBonanzaPlanDTO = new ProxyBonanzaPlanDTO();
        $proxyBonanzaPlanDTO
            ->setPlanId($proxyBonanzaPlan->getPlanId())
            ->setPlanLogin($proxyBonanzaPlan->getPlanLogin())
            ->setPlanPassword($proxyBonanzaPlan->getPlanPassword())
            ->setPlanExpires($proxyBonanzaPlan->getPlanExpires())
            ->setPlanBandwidth($proxyBonanzaPlan->getPlanBandwidth())
            ->setPlanLastIpChange($proxyBonanzaPlan->getPlanLastIpChange())
            ->setPlanPackageName($proxyBonanzaPlan->getPlanPackageName())
            ->setPlanPackageBandwidth($proxyBonanzaPlan->getPlanPackageBandwidth())
            ->setPlanPackagePrice($proxyBonanzaPlan->getPlanPackagePrice())
            ->setPlanPackageHowmanyIps($proxyBonanzaPlan->getPlanPackageHowmanyIps())
            ->setPlanPackagePricePerGig($proxyBonanzaPlan->getPlanPackagePricePerGig())
            ->setPlanPackageType($proxyBonanzaPlan->getPlanPackageType())
        ;

        return $proxyBonanzaPlanDTO;
    }
}
