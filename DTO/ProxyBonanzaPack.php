<?php

namespace WowApps\ProxyBonanzaBundle\DTO;

class ProxyBonanzaPack
{
    /** @var string */
    private $packIp;

    /** @var int */
    private $packPlan;

    /** @var string */
    private $packLogin;

    /** @var string */
    private $packPassword;

    /** @var int */
    private $packPortHttp;

    /** @var int */
    private $packPortSocks;

    /** @var int */
    private $packRegionId;

    /** @var string */
    private $packRegionName;

    /** @var string */
    private $packRegionCountryName;

    /**
     * @return string
     */
    public function getPackIp(): string
    {
        return $this->packIp;
    }

    /**
     * @param string $packIp
     * @return ProxyBonanzaPack
     */
    public function setPackIp(string $packIp)
    {
        $this->packIp = $packIp;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackPlan(): int
    {
        return $this->packPlan;
    }

    /**
     * @param int $packPlan
     * @return ProxyBonanzaPack
     */
    public function setPackPlan(int $packPlan)
    {
        $this->packPlan = $packPlan;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackLogin(): string
    {
        return $this->packLogin;
    }

    /**
     * @param string $packLogin
     * @return ProxyBonanzaPack
     */
    public function setPackLogin(string $packLogin): ProxyBonanzaPack
    {
        $this->packLogin = $packLogin;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackPassword(): string
    {
        return $this->packPassword;
    }

    /**
     * @param string $packPassword
     * @return ProxyBonanzaPack
     */
    public function setPackPassword(string $packPassword): ProxyBonanzaPack
    {
        $this->packPassword = $packPassword;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackPortHttp(): int
    {
        return $this->packPortHttp;
    }

    /**
     * @param int $packPortHttp
     * @return ProxyBonanzaPack
     */
    public function setPackPortHttp(int $packPortHttp)
    {
        $this->packPortHttp = $packPortHttp;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackPortSocks(): int
    {
        return $this->packPortSocks;
    }

    /**
     * @param int $packPortSocks
     * @return ProxyBonanzaPack
     */
    public function setPackPortSocks(int $packPortSocks)
    {
        $this->packPortSocks = $packPortSocks;
        return $this;
    }

    /**
     * @return int
     */
    public function getPackRegionId(): int
    {
        return $this->packRegionId;
    }

    /**
     * @param int $packRegionId
     * @return ProxyBonanzaPack
     */
    public function setPackRegionId(int $packRegionId)
    {
        $this->packRegionId = $packRegionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackRegionName(): string
    {
        return (!is_null($this->packRegionName) ? $this->packRegionName : '');
    }

    /**
     * @param string $packRegionName
     * @return ProxyBonanzaPack
     */
    public function setPackRegionName(string $packRegionName)
    {
        $this->packRegionName = $packRegionName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackRegionCountryName(): string
    {
        return (!is_null($this->packRegionCountryName) ? $this->packRegionCountryName : '');
    }

    /**
     * @param string $regionCountry
     * @return ProxyBonanzaPack
     */
    public function setPackRegionCountryName(string $regionCountry)
    {
        $this->packRegionCountryName = $regionCountry;
        return $this;
    }
}
