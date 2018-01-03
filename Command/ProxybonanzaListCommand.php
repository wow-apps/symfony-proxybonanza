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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WowApps\ProxybonanzaBundle\Entity\Plan;
use WowApps\ProxybonanzaBundle\Entity\Proxy;
use WowApps\ProxybonanzaBundle\Service\ProxyBonanza;
use WowApps\ProxybonanzaBundle\Traits\HelperTrait;

/**
 * Class ProxybonanzaListCommand
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
class ProxybonanzaListCommand extends ContainerAwareCommand
{
    use HelperTrait;

    const ALLOWED_OPTION_SHOW = ['all', 'remote', 'local'];

    protected function configure()
    {
        $this
            ->setName('wowapps:proxybonanza:list')
            ->setDescription('Show\'s list of proxies')
            ->addOption('show', null, InputOption::VALUE_OPTIONAL, 'Show all | remote | local')
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
        $listShow = 'all';

        $symfonyStyle = new SymfonyStyle($input, $output);

        /** @var ProxyBonanza $proxyBonanza */
        $proxyBonanza = $this->getContainer()->get('wowapps.proxybonanza');

        $symfonyStyle->title(' P R O X Y   B O N A N Z A   L I S T ');

        if ($input->getOption('show') && in_array(strtolower($input->getOption('show')), self::ALLOWED_OPTION_SHOW)) {
            $listShow = strtolower($input->getOption('show'));
        }

        if ($listShow == 'all' || $listShow == 'local') {
            $symfonyStyle->section(' List of local proxies: ');

            $pbPlans = $proxyBonanza->getLocalPlans();
            $pbPlans = $proxyBonanza->getLocalPlansProxies($pbPlans);

            $header = ['ip', 'http port', 'socks port', 'login', 'password', 'region'];

            $body = [];

            /** @var Plan $pbPlan */
            foreach ($pbPlans as $pbPlan) {
                $symfonyStyle->text(sprintf(' Proxy plan #%d local proxies:', $pbPlan->getId()));

                /** @var Proxy $proxy */
                foreach ($pbPlan->getProxy() as $proxy) {
                    $body[] = [
                        $proxy->getProxyIp(),
                        $proxy->getProxyPortHttp(),
                        $proxy->getProxyPortSocks(),
                        $proxy->getPlan()->getLogin(),
                        $proxy->getPlan()->getPassword(),
                        $proxy->getProxyRegionCountryName()
                    ];
                }

                $symfonyStyle->table($header, $body);
            }
        }

        if ($listShow == 'all' || $listShow == 'remote') {
            $symfonyStyle->section(' List of remote proxies: ');

            $pbPlans = $proxyBonanza->getRemotePlans();
            $pbPlans = $proxyBonanza->getRemotePacks($pbPlans);

            $header = ['ip', 'http port', 'socks port', 'login', 'password', 'region'];

            $body = [];

            /** @var Plan $pbPlan */
            foreach ($pbPlans as $pbPlan) {
                $symfonyStyle->text(sprintf(' Proxy plan #%d remote proxies:', $pbPlan->getId()));

                /** @var Proxy $proxy */
                foreach ($pbPlan->getProxy() as $proxy) {
                    $body[] = [
                        $proxy->getProxyId(),
                        $proxy->getProxyPortHttp(),
                        $proxy->getProxyPortSocks(),
                        $proxy->getPlan()->getLogin(),
                        $proxy->getPlan()->getPassword(),
                        $proxy->getProxyRegionCountryName()
                    ];
                }

                $symfonyStyle->table($header, $body);
            }
        }

        $symfonyStyle->note(sprintf('Command is executed in %s seconds', $this->formatSpentTime($timeStart)));

        $symfonyStyle->newLine(2);
    }
}
