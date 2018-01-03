<?php
/**
 * This file is part of the wow-apps/symfony-proxybonanza project
 * https://github.com/wow-apps/symfony-proxybonanza
 *
 * (c) 2016 WoW-Apps
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WowApps\ProxybonanzaBundle\Traits;

/**
 * Trait HelperTrait
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
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

    /**
     * @param \ArrayObject $arrayObject
     * @return array
     */
    public function getArrayObjectKeys(\ArrayObject $arrayObject): array
    {
        $keys = [];

        if (!empty($arrayObject)) {
            foreach ($arrayObject as $key => $value) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    /**
     * @param float $timeStart
     * @return float
     */
    public function formatSpentTime(float $timeStart): float
    {
        return round(microtime(true) - $timeStart, 2);
    }
}
