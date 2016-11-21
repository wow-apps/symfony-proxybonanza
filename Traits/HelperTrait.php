<?php

namespace WowApps\ProxyBonanzaBundle\Traits;

trait HelperTrait
{
    /**
     * @param string $date
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    public function convertDateTime(string $date): \DateTime
    {
        return new \DateTime($date);
    }

    /**
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public function formatSizeUnits(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'Kb', 'Mb', 'Gb', 'Tb'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . $units[$pow];
    }
}
