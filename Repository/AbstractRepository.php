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

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class AbstractRepository
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
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
