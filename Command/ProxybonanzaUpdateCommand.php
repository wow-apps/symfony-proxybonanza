<?php

namespace WowApps\ProxyBonanzaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPack;
use WowApps\ProxyBonanzaBundle\DTO\ProxyBonanzaPlan;
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
        /** @var ProxyBonanza $proxyBonanza */
        $proxyBonanza = $this->getContainer()->get('wowapps.proxybonanza');

        $symfonyStyle = new SymfonyStyle($input, $output);


        $symfonyStyle->title(' P R O X Y   B O N A N Z A   A P I ');

        $proxyBonanzaPlans = $this->getRemotePlans($proxyBonanza, $symfonyStyle);

        if (!$input->getOption('skip-tests') && $proxyBonanzaPlans->count()) {
            $this->testProxies($proxyBonanza, $proxyBonanzaPlans, $symfonyStyle);
        }

        $symfonyStyle->section('Updating local data from remote ...');

        $proxyBonanza->updateLocalDataFromRemote($proxyBonanzaPlans);

        $symfonyStyle->success('Proxy list has been updated');
    }

    /**
     * @param ProxyBonanza $proxyBonanza
     * @param SymfonyStyle $symfonyStyle
     * @return \ArrayObject|ProxyBonanzaPlan[]
     */
    private function getRemotePlans(ProxyBonanza $proxyBonanza, SymfonyStyle $symfonyStyle)
    {

        $symfonyStyle->section(' Getting remote data from ProxyBonanza ');

        $symfonyStyle->createProgressBar(100);
        $symfonyStyle->progressStart(0);

        /** @var \ArrayObject|ProxyBonanzaPlan[] $proxyBonanzaRemotePlans */
        $proxyBonanzaRemotePlans = $proxyBonanza->getRemotePlans();
        if (!$proxyBonanzaRemotePlans->count()) {
            return $proxyBonanzaRemotePlans;
        } else {
            $symfonyStyle->progressAdvance(50);

            $proxyBonanzaRemotePlans = $proxyBonanza->getRemotePacks($proxyBonanzaRemotePlans);

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

            foreach ($proxyBonanzaRemotePlans as $bonanzaPlan) {
                $body[] = [
                    $bonanzaPlan->getPlanId(),
                    $bonanzaPlan->getPlanLogin(),
                    $bonanzaPlan->getPlanPassword(),
                    $bonanzaPlan->getPlanExpires()->format('Y-m-d H:i'),
                    $this->formatSizeUnits($bonanzaPlan->getPlanBandwidth(), 2),
                    $bonanzaPlan->getPlanLastIpChange()->format('Y-m-d H:i'),
                    $bonanzaPlan->getPlanPackageName(),
                    $this->formatSizeUnits($bonanzaPlan->getPlanPackageBandwidth(), 2),
                    $bonanzaPlan->getPlanPackagePrice(),
                    $bonanzaPlan->getPlanPackageHowmanyIps(),
                    $bonanzaPlan->getPlanPackagePricePerGig(),
                    $bonanzaPlan->getPlanPackageType()
                ];
            }

            $symfonyStyle->table($header, $body);
        }

        return $proxyBonanzaRemotePlans;
    }

    /**
     * @param ProxyBonanza $proxyBonanza
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonanzaPlans
     * @param SymfonyStyle $symfonyStyle
     */
    private function testProxies(
        ProxyBonanza $proxyBonanza,
        \ArrayObject $proxyBonanzaPlans,
        SymfonyStyle $symfonyStyle
    ) {
        /** @var ProxyBonanzaPlan $proxyBonanzaPlan */
        foreach ($proxyBonanzaPlans as $proxyBonanzaPlan) {
            $brokenProxies = new \ArrayObject();

            $symfonyStyle->section(sprintf(' Testing proxies of plan #%d ', $proxyBonanzaPlan->getPlanId()));

            $symfonyStyle->createProgressBar();
            $symfonyStyle->progressStart($proxyBonanzaPlan->getPlanPackageHowmanyIps());

            /** @var ProxyBonanzaPack $ipPack */
            foreach ($proxyBonanzaPlan->getIppacks() as $ipPack) {
                if (!$proxyBonanza->testProxyConnection($ipPack)) {
                    $brokenProxies->append($ipPack);
                }

                $symfonyStyle->progressAdvance(1);
            }

            $symfonyStyle->progressFinish();

            if ($brokenProxies->count()) {
                $symfonyStyle->warning(sprintf('%d proxies doesn\'t work!', $brokenProxies->count()));

                $header = [
                    'ip',
                    'port',
                    'login',
                    'password'
                ];

                $body = [];

                /** @var ProxyBonanzaPack $brokenProxy */
                foreach ($brokenProxies as $brokenProxy) {
                    $body[] = [
                        $brokenProxy->getPackIp(),
                        $brokenProxy->getPackPortHttp(),
                        $brokenProxy->getPackLogin(),
                        $brokenProxy->getPackPassword()
                    ];
                }

                $symfonyStyle->table($header, $body);
            } else {
                $symfonyStyle->success('All proxies works!');
            }
        }
    }
}
