<?php

namespace Wowapps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_plan",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"}
 * )
 * @ORM\Entity(repositoryClass="Wowapps\ProxyBonanzaBundle\Repository\PlanRepository")
 */
class Plan
{
    const TABLE_NAME = 'proxybonanza_plan';

    /**
     * @var integer
     * @ORM\Column(name="plan_id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="plan_login", type="string", nullable=false)
     */
    private $login;

    /**
     * @var string
     * @ORM\Column(name="plan_password", type="string", nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     * @ORM\Column(name="plan_expires", type="datetime", nullable=true)
     */
    private $expires;

    /**
     * @var int
     * @ORM\Column(name="plan_bandwidth", type="integer", nullable=true)
     */
    private $bandwidth;

    /**
     * @var \DateTime
     * @ORM\Column(name="plan_last_ip_change", type="datetime", nullable=true)
     */
    private $lastIpChange;

    /**
     * @var string
     * @ORM\Column(name="plan_package_name", type="string", nullable=true)
     */
    private $packageName;

    /**
     * @var string
     * @ORM\Column(name="plan_package_bandwidth", type="string", nullable=true)
     */
    private $packageBandwidth;

    /**
     * @var float
     * @ORM\Column(name="plan_package_price", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $packagePrice;

    /**
     * @var int
     * @ORM\Column(name="plan_package_howmany_ips", type="integer", nullable=true)
     */
    private $packageHowmanyIps;

    /**
     * @var int
     * @ORM\Column(name="plan_package_price_per_gig", type="integer", nullable=true)
     */
    private $packagePricePerGig;

    /**
     * @var string
     * @ORM\Column(name="plan_package_type", type="string", nullable=true)
     */
    private $packageType;

    /**
     * @var \ArrayObject|Proxy[]
     */
    private $proxy;

    /** @var \ArrayObject|AuthIps[] */
    private $authIps;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Plan
     */
    public function setId(int $id): Plan
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return Plan
     */
    public function setLogin(string $login): Plan
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Plan
     */
    public function setPassword(string $password): Plan
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpires(): \DateTime
    {
        return $this->expires;
    }

    /**
     * @param \DateTime $expires
     * @return Plan
     */
    public function setExpires(\DateTime $expires): Plan
    {
        $this->expires = $expires;
        return $this;
    }

    /**
     * @return int
     */
    public function getBandwidth(): int
    {
        return $this->bandwidth;
    }

    /**
     * @param int $bandwidth
     * @return Plan
     */
    public function setBandwidth(int $bandwidth): Plan
    {
        $this->bandwidth = $bandwidth;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastIpChange(): \DateTime
    {
        return $this->lastIpChange;
    }

    /**
     * @param \DateTime $lastIpChange
     * @return Plan
     */
    public function setLastIpChange(\DateTime $lastIpChange): Plan
    {
        $this->lastIpChange = $lastIpChange;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @param string $packageName
     * @return Plan
     */
    public function setPackageName(string $packageName): Plan
    {
        $this->packageName = $packageName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackageBandwidth(): string
    {
        return $this->packageBandwidth;
    }

    /**
     * @param string $packageBandwidth
     * @return Plan
     */
    public function setPackageBandwidth(string $packageBandwidth): Plan
    {
        $this->packageBandwidth = $packageBandwidth;
        return $this;
    }

    /**
     * @return float
     */
    public function getPackagePrice(): float
    {
        return $this->packagePrice;
    }

    /**
     * @param float $packagePrice
     * @return Plan
     */
    public function setPackagePrice(float $packagePrice): Plan
    {
        $this->packagePrice = $packagePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackageHowmanyIps(): int
    {
        return $this->packageHowmanyIps;
    }

    /**
     * @param int $packageHowmanyIps
     * @return Plan
     */
    public function setPackageHowmanyIps(int $packageHowmanyIps): Plan
    {
        $this->packageHowmanyIps = $packageHowmanyIps;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackagePricePerGig(): int
    {
        return $this->packagePricePerGig;
    }

    /**
     * @param int $packagePricePerGig
     * @return Plan
     */
    public function setPackagePricePerGig(int $packagePricePerGig): Plan
    {
        $this->packagePricePerGig = $packagePricePerGig;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackageType(): string
    {
        return $this->packageType;
    }

    /**
     * @param string $packageType
     * @return Plan
     */
    public function setPackageType(string $packageType): Plan
    {
        $this->packageType = $packageType;
        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getProxy(): \ArrayObject
    {
        return $this->proxy;
    }

    /**
     * @param \ArrayObject $proxy
     */
    public function setProxy(\ArrayObject $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @param Proxy $proxy
     * @return Plan
     */
    public function appendProxy(Proxy $proxy): Plan
    {
        if (!$this->proxy) {
            $this->proxy = new \ArrayObject();
        }

        $this->proxy->offsetSet($proxy->getProxyId(), $proxy);

        return $this;
    }

    /**
     * @return \ArrayObject|AuthIps[]
     */
    public function getAuthIps()
    {
        return $this->authIps;
    }

    /**
     * @param \ArrayObject|AuthIps[] $authIps
     * @return Plan
     */
    public function setAuthIps($authIps)
    {
        $this->authIps = $authIps;
        return $this;
    }

    /**
     * @param AuthIps $authIp
     * @return Plan
     */
    public function appendAuthIp(AuthIps $authIp): Plan
    {
        if (!$this->authIps) {
            $this->authIps = new \ArrayObject();
        }

        $this->authIps->offsetSet($authIp->getId(), $authIp);

        return $this;
    }
}
