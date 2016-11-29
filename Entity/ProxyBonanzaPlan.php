<?php

namespace WowApps\ProxyBonanzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="proxybonanza_plan",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"}
 * )
 * @ORM\Entity(repositoryClass="WowApps\ProxyBonanzaBundle\Repository\ProxyBonanzaPlanRepository")
 */
class ProxyBonanzaPlan
{
    const TABLE_NAME = 'proxybonanza_plan';

    /**
     * @var integer
     * @ORM\Column(name="plan_id", type="integer")
     * @ORM\Id
     */
    private $planId;

    /**
     * @var string
     * @ORM\Column(name="plan_login", type="string", nullable=false)
     */
    private $planLogin;

    /**
     * @var string
     * @ORM\Column(name="plan_password", type="string", nullable=false)
     */
    private $planPassword;

    /**
     * @var \DateTime
     * @ORM\Column(name="plan_expires", type="datetime", nullable=true)
     */
    private $planExpires;

    /**
     * @var int
     * @ORM\Column(name="plan_bandwidth", type="integer", nullable=true)
     */
    private $planBandwidth;

    /**
     * @var \DateTime
     * @ORM\Column(name="plan_last_ip_change", type="datetime", nullable=true)
     */
    private $planLastIpChange;

    /**
     * @var string
     * @ORM\Column(name="plan_package_name", type="string", nullable=true)
     */
    private $planPackageName;

    /**
     * @var string
     * @ORM\Column(name="plan_package_bandwidth", type="string", nullable=true)
     */
    private $planPackageBandwidth;

    /**
     * @var float
     * @ORM\Column(name="plan_package_price", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $planPackagePrice;

    /**
     * @var int
     * @ORM\Column(name="plan_package_howmany_ips", type="integer", nullable=true)
     */
    private $planPackageHowmanyIps;

    /**
     * @var int
     * @ORM\Column(name="plan_package_price_per_gig", type="integer", nullable=true)
     */
    private $planPackagePricePerGig;

    /**
     * @var string
     * @ORM\Column(name="plan_package_type", type="string", nullable=true)
     */
    private $planPackageType;

    /**
     * @return int
     */
    public function getPlanId(): int
    {
        return $this->planId;
    }

    /**
     * @param int $planId
     * @return ProxyBonanzaPlan
     */
    public function setPlanId(int $planId): ProxyBonanzaPlan
    {
        $this->planId = $planId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanLogin(): string
    {
        return $this->planLogin;
    }

    /**
     * @param string $planLogin
     * @return ProxyBonanzaPlan
     */
    public function setPlanLogin(string $planLogin): ProxyBonanzaPlan
    {
        $this->planLogin = $planLogin;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanPassword(): string
    {
        return $this->planPassword;
    }

    /**
     * @param string $planPassword
     * @return ProxyBonanzaPlan
     */
    public function setPlanPassword(string $planPassword): ProxyBonanzaPlan
    {
        $this->planPassword = $planPassword;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPlanExpires(): \DateTime
    {
        return $this->planExpires;
    }

    /**
     * @param \DateTime $planExpires
     * @return ProxyBonanzaPlan
     */
    public function setPlanExpires(\DateTime $planExpires): ProxyBonanzaPlan
    {
        $this->planExpires = $planExpires;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlanBandwidth(): int
    {
        return $this->planBandwidth;
    }

    /**
     * @param int $planBandwidth
     * @return ProxyBonanzaPlan
     */
    public function setPlanBandwidth(int $planBandwidth): ProxyBonanzaPlan
    {
        $this->planBandwidth = $planBandwidth;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPlanLastIpChange(): \DateTime
    {
        return $this->planLastIpChange;
    }

    /**
     * @param \DateTime $planLastIpChange
     * @return ProxyBonanzaPlan
     */
    public function setPlanLastIpChange(\DateTime $planLastIpChange): ProxyBonanzaPlan
    {
        $this->planLastIpChange = $planLastIpChange;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanPackageName(): string
    {
        return $this->planPackageName;
    }

    /**
     * @param string $planPackageName
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackageName(string $planPackageName): ProxyBonanzaPlan
    {
        $this->planPackageName = $planPackageName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanPackageBandwidth(): string
    {
        return $this->planPackageBandwidth;
    }

    /**
     * @param string $planPackageBandwidth
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackageBandwidth(string $planPackageBandwidth): ProxyBonanzaPlan
    {
        $this->planPackageBandwidth = $planPackageBandwidth;
        return $this;
    }

    /**
     * @return float
     */
    public function getPlanPackagePrice(): float
    {
        return $this->planPackagePrice;
    }

    /**
     * @param float $planPackagePrice
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackagePrice(float $planPackagePrice): ProxyBonanzaPlan
    {
        $this->planPackagePrice = $planPackagePrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlanPackageHowmanyIps(): int
    {
        return $this->planPackageHowmanyIps;
    }

    /**
     * @param int $planPackageHowmanyIps
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackageHowmanyIps(int $planPackageHowmanyIps): ProxyBonanzaPlan
    {
        $this->planPackageHowmanyIps = $planPackageHowmanyIps;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlanPackagePricePerGig(): int
    {
        return $this->planPackagePricePerGig;
    }

    /**
     * @param int $planPackagePricePerGig
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackagePricePerGig(int $planPackagePricePerGig): ProxyBonanzaPlan
    {
        $this->planPackagePricePerGig = $planPackagePricePerGig;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanPackageType(): string
    {
        return $this->planPackageType;
    }

    /**
     * @param string $planPackageType
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackageType(string $planPackageType): ProxyBonanzaPlan
    {
        $this->planPackageType = $planPackageType;
        return $this;
    }
}
