<?php

namespace WowApps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_proxies",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"}
 * )
 * @ORM\Entity(repositoryClass="WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaProxiesRepository")
 */
class ProxyBonanzaProxies
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
     * @return int
     */
    public function getProxyId(): int
    {
        return $this->proxyId;
    }

    /**
     * @param int $proxyId
     * @return ProxyBonanzaProxies
     */
    public function setProxyId(int $proxyId): ProxyBonanzaProxies
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
     * @return ProxyBonanzaProxies
     */
    public function setProxyPlan(int $proxyPlan): ProxyBonanzaProxies
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
     * @return ProxyBonanzaProxies
     */
    public function setProxyIp(string $proxyIp): ProxyBonanzaProxies
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
     * @return ProxyBonanzaProxies
     */
    public function setProxyPortHttp(int $proxyPortHttp): ProxyBonanzaProxies
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
     * @return ProxyBonanzaProxies
     */
    public function setProxyPortSocks(int $proxyPortSocks): ProxyBonanzaProxies
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
     * @return ProxyBonanzaProxies
     */
    public function setProxyRegionId(int $proxyRegionId): ProxyBonanzaProxies
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
     * @return ProxyBonanzaProxies
     */
    public function setProxyRegionName(string $proxyRegionName): ProxyBonanzaProxies
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
     * @param string $proxyRegionCountryName
     * @return ProxyBonanzaProxies
     */
    public function setProxyRegionCountryName(string $proxyRegionCountryName): ProxyBonanzaProxies
    {
        $this->proxyRegionCountryName = $proxyRegionCountryName;
        return $this;
    }
}
