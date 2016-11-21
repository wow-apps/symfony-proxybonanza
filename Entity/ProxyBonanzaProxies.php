<?php

namespace WowApps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_proxies",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"},
 *     indexes={
 *      @ORM\Index(name="ix_proxybonanza_proxies_1", columns={"proxy_id"}),
 *     }
 * )
 * @ORM\Entity(repositoryClass="Op\CompetitorsBundle\Repository\ProxyBonanzaProxiesRepository")
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
     */
    public function setProxyId(int $proxyId)
    {
        $this->proxyId = $proxyId;
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
     */
    public function setProxyPlan(int $proxyPlan)
    {
        $this->proxyPlan = $proxyPlan;
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
     */
    public function setProxyIp(string $proxyIp)
    {
        $this->proxyIp = $proxyIp;
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
     */
    public function setProxyPortHttp(int $proxyPortHttp)
    {
        $this->proxyPortHttp = $proxyPortHttp;
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
     */
    public function setProxyPortSocks(int $proxyPortSocks)
    {
        $this->proxyPortSocks = $proxyPortSocks;
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
     */
    public function setProxyRegionId(int $proxyRegionId)
    {
        $this->proxyRegionId = $proxyRegionId;
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
     */
    public function setProxyRegionName(string $proxyRegionName)
    {
        $this->proxyRegionName = $proxyRegionName;
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
     */
    public function setProxyRegionCountryName(string $proxyRegionCountryName)
    {
        $this->proxyRegionCountryName = $proxyRegionCountryName;
    }
}
