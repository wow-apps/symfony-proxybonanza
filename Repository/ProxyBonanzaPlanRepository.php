<?php

namespace WowApps\ProxyBonanzaBundle\Repository;

use WowApps\ProxyBonanzaBundle\Entity\ProxyBonanzaPlan;

class ProxyBonanzaPlanRepository extends AbstractRepository
{
    public function deleteAll()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->delete(ProxyBonanzaPlan::TABLE_NAME);
        $qb->execute();
    }
}
