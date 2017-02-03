<?php

namespace WowApps\ProxyBonanzaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WowApps\ProxyBonanzaBundle\Entity\Plan;
use WowApps\ProxyBonanzaBundle\Entity\Proxy;
use WowApps\ProxyBonanzaBundle\Service\ProxyBonanza;
use WowApps\ProxyBonanzaBundle\Traits\HelperTrait;

class ProxybonanzaListCommand extends ContainerAwareCommand
{
    use HelperTrait;

    const ALLOWED_OPTION_SHOW = ['all', 'remote', 'local'];

    protected function configure()
    {
        $this
            ->setName('proxybonanza:list')
            ->setDescription('Show\'s list of proxies')
            ->addOption('show', null, InputOption::VALUE_OPTIONAL, 'Show all | remote | local')
        ;
    }

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
