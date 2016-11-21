<?php

namespace WowApps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_auth_ips",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"},
 *     indexes={
 *      @ORM\Index(name="ix_proxybonanza_auth_ips_1", columns={"authips_id"}),
 *     }
 * )
 * @ORM\Entity(repositoryClass="Op\CompetitorsBundle\Repository\ProxyBonanzaAuthIpsRepository")
 */
class ProxyBonanzaAuthIps
{
    const TABLE_NAME = 'proxybonanza_auth_ips';

    /**
     * @var integer
     * @ORM\Column(name="authips_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="authips_plan", type="integer", nullable=false)
     */
    private $plan;

    /**
     * @var string
     * @ORM\Column(name="authips_ip", type="string", nullable=false)
     */
    private $ip;
}
