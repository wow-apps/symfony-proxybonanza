<?php

namespace Wowapps\ProxyBonanzaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Wowapps\ProxyBonanzaBundle\Entity\Plan;
use Wowapps\ProxyBonanzaBundle\Entity\Proxy;
use Wowapps\ProxyBonanzaBundle\Service\ProxyBonanza;
use Wowapps\ProxyBonanzaBundle\Traits\HelperTrait;

class ProxybonanzaTestCommand extends ContainerAwareCommand
{
    use HelperTrait;

    protected function configure()
    {
        $this
            ->setName('proxybonanza:test')
            ->setDescription('Test all local proxies')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);

        /** @var ProxyBonanza $proxyBonanza */
        $proxyBonanza = $this->getContainer()->get('wowapps.proxybonanza');

        $symfonyStyle = new SymfonyStyle($input, $output);


        $symfonyStyle->title(' P R O X Y   B O N A N Z A   T E S T ');

        $pbPlans = $proxyBonanza->getLocalPlans();
        $pbPlans = $proxyBonanza->getLocalPlansProxies($pbPlans);

        $brokenProxies = new \ArrayObject();

        /** @var Plan $pbPlan */
        foreach ($pbPlans as $pbPlan) {
            $symfonyStyle->section(sprintf(' Start testing local proxies of plan #%d', $pbPlan->getId()));

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
        }

        if (!$brokenProxies->count()) {
            $symfonyStyle->success('All proxies works!');
        } else {
            $symfonyStyle->warning(sprintf('%d local proxies doesn\'t work!', $brokenProxies->count()));

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
        }

        $symfonyStyle->note(sprintf('Command is executed in %s seconds', $this->formatSpentTime($timeStart)));

        $symfonyStyle->newLine(2);
    }
}
