<?php

namespace Wowapps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_proxies",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"}
 * )
 * @ORM\Entity(repositoryClass="Wowapps\ProxyBonanzaBundle\Repository\ProxiesRepository")
 */
class Proxy
{
    const TABLE_NAME = 'proxybonanza_proxies';

    /**
     * @var integer
     * @ORM\Column(name="proxy_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proxyId;

    /**
     * @var integer
     * @ORM\Column(name="proxy_plan", type="integer", nullable=false)
     */
    private $proxyPlan;

    /**
     * @var string
     * @ORM\Column(name="proxy_ip", type="string", nullable=false)
     */
    private $proxyIp;

    /**
     * @var integer
     * @ORM\Column(name="proxy_port_http", type="integer", nullable=true)
     */
    private $proxyPortHttp;

    /**
     * @var integer
     * @ORM\Column(name="proxy_port_socks", type="integer", nullable=true)
     */
    private $proxyPortSocks;

    /**
     * @var integer
     * @ORM\Column(name="proxy_region_id", type="integer", nullable=true)
     */
    private $proxyRegionId;

    /**
     * @var string
     * @ORM\Column(name="proxy_region_name", type="string", nullable=true)
     */
    private $proxyRegionName;

    /**
     * @var string
     * @ORM\Column(name="proxy_region_country", type="string", nullable=true)
     */
    private $proxyRegionCountryName;

    /**
     * @var Plan
     * @ORM\OneToOne(targetEntity="Plan", fetch="EAGER")
     * @ORM\JoinColumn(name="proxy_plan", referencedColumnName="plan_id")
     */
    private $plan;

    /**
     * @return int
     */
    public function getProxyId(): int
    {
        return $this->proxyId;
    }

    /**
     * @param int $proxyId
     * @return Proxy
     */
    public function setProxyId(int $proxyId): Proxy
    {
        $this->proxyId = $proxyId;
        return $this;
    }

    /**
     * @return int
     */
    public function getProxyPlan(): int
    {
        return $this->proxyPlan;
    }

    /**
     * @param int $proxyPlan
     * @return Proxy
     */
    public function setProxyPlan(int $proxyPlan): Proxy
    {
        $this->proxyPlan = $proxyPlan;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyIp(): string
    {
        return $this->proxyIp;
    }

    /**
     * @param string $proxyIp
     * @return Proxy
     */
    public function setProxyIp(string $proxyIp): Proxy
    {
        $this->proxyIp = $proxyIp;
        return $this;
    }

    /**
     * @return int
     */
    public function getProxyPortHttp(): int
    {
        return $this->proxyPortHttp;
    }

    /**
     * @param int $proxyPortHttp
     * @return Proxy
     */
    public function setProxyPortHttp(int $proxyPortHttp): Proxy
    {
        $this->proxyPortHttp = $proxyPortHttp;
        return $this;
    }

    /**
     * @return int
     */
    public function getProxyPortSocks(): int
    {
        return $this->proxyPortSocks;
    }

    /**
     * @param int $proxyPortSocks
     * @return Proxy
     */
    public function setProxyPortSocks(int $proxyPortSocks): Proxy
    {
        $this->proxyPortSocks = $proxyPortSocks;
        return $this;
    }

    /**
     * @return int
     */
    public function getProxyRegionId(): int
    {
        return $this->proxyRegionId;
    }

    /**
     * @param int $proxyRegionId
     * @return Proxy
     */
    public function setProxyRegionId(int $proxyRegionId): Proxy
    {
        $this->proxyRegionId = $proxyRegionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyRegionName(): string
    {
        return $this->proxyRegionName;
    }

    /**
     * @param string $proxyRegionName
     * @return Proxy
     */
    public function setProxyRegionName(string $proxyRegionName): Proxy
    {
        $this->proxyRegionName = $proxyRegionName;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyRegionCountryName(): string
    {
        return $this->proxyRegionCountryName;
    }

    /**
     * @param string $proxyRegionCountry
     * @return Proxy
     */
    public function setProxyRegionCountryName(string $proxyRegionCountry): Proxy
    {
        $this->proxyRegionCountryName = $proxyRegionCountry;
        return $this;
    }

    /**
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return $this->plan;
    }

    /**
     * @param Plan $plan
     * @return Proxy
     */
    public function setPlan(Plan $plan): Proxy
    {
        $this->plan = $plan;
        return $this;
    }
}
