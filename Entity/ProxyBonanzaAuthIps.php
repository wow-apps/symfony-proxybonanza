<?php

namespace WowApps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_auth_ips",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"}
 * )
 * @ORM\Entity(repositoryClass="WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaAuthIpsRepository")
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ProxyBonanzaAuthIps
     */
    public function setId(int $id): ProxyBonanzaAuthIps
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlan(): int
    {
        return $this->plan;
    }

    /**
     * @param int $plan
     * @return ProxyBonanzaAuthIps
     */
    public function setPlan(int $plan): ProxyBonanzaAuthIps
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return ProxyBonanzaAuthIps
     */
    public function setIp(string $ip): ProxyBonanzaAuthIps
    {
        $this->ip = $ip;
        return $this;
    }
}
