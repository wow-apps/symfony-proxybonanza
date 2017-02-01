<?php

namespace WowApps\ProxyBonanzaBundle\Repository;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

abstract class AbstractRepository extends EntityRepository
{
    /** @var PDOConnection */
    protected $db;

    /** @var EntityManager */
    protected $em;

    /**
     * AbstractRepository constructor.
     * @param EntityManager $em
     * @param Mapping\ClassMetadata $class
     */
    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
        $this->db = $em->getConnection();
    }

    /**
     * @param string $value
     * @return string
     */
    protected function quote(string $value): string
    {
        $emptyValues = ['%', '%%', '_'];
        if (($value === 0) || (!empty($value) && !in_array($value, $emptyValues))) {
            return $this->db->quote($value);
        }

        return 'NULL';
    }
}
