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

namespace WowApps\ProxybonanzaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WowApps\ProxybonanzaBundle\Service\ProxyBonanza;
use WowApps\ProxybonanzaBundle\Traits\HelperTrait;

/**
 * Class ProxybonanzaGetRandomProxyCommand
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
class ProxybonanzaGetRandomProxyCommand extends ContainerAwareCommand
{
    use HelperTrait;

    protected function configure()
    {
        $this
            ->setName('wowapps:proxybonanza:random')
            ->setDescription('View random proxy')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);

        /** @var ProxyBonanza $proxyBonanza */
        $proxyBonanza = $this->getContainer()->get('wowapps.proxybonanza');

        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->title(' P R O X Y   B O N A N Z A   R A N D O M   P R O X Y ');

        $randomProxy = $proxyBonanza->getRandomProxy(
            $proxyBonanza->getLocalProxies()
        );

        $header = ['ip', 'http port', 'socks port', 'login', 'password', 'region'];

        $body[] = [
            $randomProxy->getProxyId(),
            $randomProxy->getProxyPortHttp(),
            $randomProxy->getProxyPortSocks(),
            $randomProxy->getPlan()->getLogin(),
            $randomProxy->getPlan()->getPassword(),
            $randomProxy->getProxyRegionCountryName()
        ];

        $symfonyStyle->table($header, $body);

        $symfonyStyle->note(
            sprintf(
                'Command is executed in %s seconds',
                $this->formatSpentTime($timeStart)
            )
        );

        $symfonyStyle->newLine(2);
    }
}
