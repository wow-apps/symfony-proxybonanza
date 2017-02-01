<?php

namespace WowApps\ProxyBonanzaBundle\DTO;

class ProxyBonanzaPlan
{
    /** @var integer */
    private $planId;

    /** @var string */
    private $planLogin;

    /** @var string */
    private $planPassword;

    /** @var \DateTime */
    private $planExpires;

    /** @var int */
    private $planBandwidth;

    /** @var \DateTime */
    private $planLastIpChange;

    /** @var string */
    private $planPackageName;

    /** @var string */
    private $planPackageBandwidth;

    /** @var float */
    private $planPackagePrice;

    /** @var int */
    private $planPackageHowmanyIps;

    /** @var int */
    private $planPackagePricePerGig;

    /** @var string */
    private $planPackageType;

    /** @var \ArrayObject|ProxyBonanzaPack[] */
    private $ippacks;

    /** @var array */
    private $authIps = [];

    /**
     * ProxyBonanzaPlan constructor.
     */
    public function __construct()
    {
        $this->ippacks = new \ArrayObject();
    }

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
     * @param int $howmanyIps
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackageHowmanyIps(int $howmanyIps): ProxyBonanzaPlan
    {
        $this->planPackageHowmanyIps = $howmanyIps;
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
     * @param int $pricePerGig
     * @return ProxyBonanzaPlan
     */
    public function setPlanPackagePricePerGig(int $pricePerGig): ProxyBonanzaPlan
    {
        $this->planPackagePricePerGig = $pricePerGig;
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

    /**
     * @return \ArrayObject|ProxyBonanzaPack[]
     */
    public function getIppacks(): \ArrayObject
    {
        return $this->ippacks;
    }

    /**
     * @param \ArrayObject|ProxyBonanzaPack[] $ippacks
     * @return ProxyBonanzaPlan
     */
    public function setIppacks(\ArrayObject $ippacks): ProxyBonanzaPlan
    {
        $this->ippacks = $ippacks;
        return $this;
    }

    /**
     * @param ProxyBonanzaPack $ipPack
     * @return ProxyBonanzaPlan
     */
    public function appendIpPack(ProxyBonanzaPack $ipPack): ProxyBonanzaPlan
    {
        $this->ippacks->append($ipPack);
        return $this;
    }

    /**
     * @return array
     */
    public function getAuthIps(): array
    {
        return $this->authIps;
    }

    /**
     * @param array $authIps
     * @return ProxyBonanzaPlan
     */
    public function setAuthIps(array $authIps): ProxyBonanzaPlan
    {
        $this->authIps = $authIps;
        return $this;
    }

    /**
     * @param int $insertIpId
     * @param string $insertIp
     * @return ProxyBonanzaPlan
     */
    public function appendAuthIp(int $insertIpId, string $insertIp): ProxyBonanzaPlan
    {
        $this->authIps[$insertIpId] = $insertIp;
        return $this;
    }
}
