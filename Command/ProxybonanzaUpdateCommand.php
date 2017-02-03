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

class ProxybonanzaUpdateCommand extends ContainerAwareCommand
{
    use HelperTrait;

    protected function configure()
    {
        $this
            ->setName('proxybonanza:update')
            ->setDescription('Update proxy list from ProxyBonanza')
            ->addOption('skip-tests', null, InputOption::VALUE_NONE, 'Skip test of every remote proxy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);

        /** @var ProxyBonanza $proxyBonanza */
        $proxyBonanza = $this->getContainer()->get('wowapps.proxybonanza');

        $symfonyStyle = new SymfonyStyle($input, $output);


        $symfonyStyle->title(' P R O X Y   B O N A N Z A   U P D A T E ');

        $pbPlans = $this->getRemotePlans($proxyBonanza, $symfonyStyle);

        if (!$input->getOption('skip-tests') && $pbPlans->count()) {
            $this->testProxies($proxyBonanza, $pbPlans, $symfonyStyle);
        }

        $symfonyStyle->section('Updating local data from remote ...');

        $proxyBonanza->updateLocalDataFromRemote($pbPlans);

        $symfonyStyle->success('Proxy list has been updated');

        $symfonyStyle->note(sprintf('Command is executed in %s seconds', $this->formatSpentTime($timeStart)));

        $symfonyStyle->newLine(2);
    }

    /**
     * @param ProxyBonanza $proxyBonanza
     * @param SymfonyStyle $symfonyStyle
     * @return \ArrayObject|Plan[]
     */
    private function getRemotePlans(ProxyBonanza $proxyBonanza, SymfonyStyle $symfonyStyle)
    {

        $symfonyStyle->section(' Getting remote data from ProxyBonanza ');

        $symfonyStyle->createProgressBar(100);
        $symfonyStyle->progressStart(0);

        $pbPlans = $proxyBonanza->getRemotePlans();
        if (!$pbPlans->count()) {
            return $pbPlans;
        }

        $symfonyStyle->progressAdvance(50);

        $pbPlans = $proxyBonanza->getRemotePacks($pbPlans);

        $symfonyStyle->progressAdvance(50);

        $symfonyStyle->progressFinish();

        $header = [
            'id',
            'login',
            'password',
            'expires',
            'bandwidth',
            'last ip change',
            'name',
            'bandwidth',
            'price',
            'ip\'s count',
            'price per gig',
            'type'
        ];

        $body = [];

        /** @var Plan $pbPlan */
        foreach ($pbPlans as $pbPlan) {
            $body[] = [
                $pbPlan->getId(),
                $pbPlan->getLogin(),
                $pbPlan->getPassword(),
                $pbPlan->getExpires()->format('Y-m-d H:i'),
                $this->formatSizeUnits($pbPlan->getBandwidth(), 2),
                $pbPlan->getLastIpChange()->format('Y-m-d H:i'),
                $pbPlan->getPackageName(),
                $this->formatSizeUnits($pbPlan->getPackageBandwidth(), 2),
                $pbPlan->getPackagePrice(),
                $pbPlan->getPackageHowmanyIps(),
                $pbPlan->getPackagePricePerGig(),
                $pbPlan->getPackageType()
            ];
        }

        $symfonyStyle->table($header, $body);

        return $pbPlans;
    }

    /**
     * @param ProxyBonanza $proxyBonanza
     * @param \ArrayObject|Plan[] $pbPlans
     * @param SymfonyStyle $symfonyStyle
     */
    private function testProxies(
        ProxyBonanza $proxyBonanza,
        \ArrayObject $pbPlans,
        SymfonyStyle $symfonyStyle
    ) {
        /** @var Plan $pbPlans */
        foreach ($pbPlans as $pbPlan) {
            $brokenProxies = new \ArrayObject();

            $symfonyStyle->section(sprintf(' Testing remote proxies of plan #%d ', $pbPlan->getId()));

            $symfonyStyle->createProgressBar();
            $symfonyStyle->progressStart($pbPlan->getPackageHowmanyIps());

            /** @var Proxy $proxy */
            foreach ($pbPlan->getProxy() as $proxy) {
                if (!$proxyBonanza->testProxyConnection($proxy)) {
                    $brokenProxies->append($proxy);
                }

                $symfonyStyle->progressAdvance(1);
            }

            $symfonyStyle->progressFinish();

            if ($brokenProxies->count()) {
                $symfonyStyle->warning(sprintf('%d remote proxies doesn\'t work!', $brokenProxies->count()));

                $header = [
                    'ip',
                    'port',
                    'login',
                    'password'
                ];

                $body = [];

                /** @var Proxy $brokenProxy */
                foreach ($brokenProxies as $brokenProxy) {
                    $body[] = [
                        $brokenProxy->getProxyIp(),
                        $brokenProxy->getProxyPortHttp(),
                        $brokenProxy->getPlan()->getLogin(),
                        $brokenProxy->getPlan()->getPassword()
                    ];
                }

                $symfonyStyle->table($header, $body);
            } else {
                $symfonyStyle->success('All proxies works!');
            }
        }
    }
}
