<?php

namespace Wowapps\ProxyBonanzaBundle\Repository;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

abstract class AbstractRepository extends EntityRepository
{
    /** @var PDOConnection */
    protected $pdoDB;

    /** @var EntityManager */
    protected $entityManager;

    /**
     * AbstractRepository constructor.
     * @param EntityManager $entityManager
     * @param Mapping\ClassMetadata $class
     */
    public function __construct(EntityManager $entityManager, Mapping\ClassMetadata $class)
    {
        parent::__construct($entityManager, $class);
        $this->entityManager = $entityManager;
        $this->pdoDB = $entityManager->getConnection();
    }

    /**
     * @param string $value
     * @return string
     */
    protected function quote(string $value): string
    {
        $emptyValues = ['%', '%%', '_'];
        if (($value === 0) || (!empty($value) && !in_array($value, $emptyValues))) {
            return $this->pdoDB->quote($value);
        }

        return 'NULL';
    }
}
