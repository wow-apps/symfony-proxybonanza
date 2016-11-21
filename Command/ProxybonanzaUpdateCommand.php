<?php

namespace WowApps\ProxyBonanzaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
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
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        /** @var ProxyBonanza $proxyBonanza */
        $proxyBonanza = $this->getContainer()->get('wowapps.proxybonanza');

        if ($input->getOption('option')) {
            // ...
        }

        $symfonyStyle = new SymfonyStyle($input, $output);

        $header = '<bg=black;options=bold;fg=white>       P R O X Y</>';
        $header .= '<bg=black;options=bold;fg=blue> B O N A N Z A       </>';
        echo PHP_EOL;
        $output->writeln('<bg=black;options=bold;fg=white>                                     </>');
        $output->writeln($header);
        $output->writeln('<bg=black;options=bold;fg=white>                                     </>');
        echo PHP_EOL;

        $symfonyStyle->title('Getting remote data from ProxyBonanza');

        $symfonyStyle->createProgressBar(100);
        $symfonyStyle->progressStart(0);

        $proxyBonanzaPlans = $this->getPlans($proxyBonanza);

        $symfonyStyle->progressAdvance(50);

        $proxyBonanzaPlans = $proxyBonanza->getRemotePacks($proxyBonanzaPlans);

        $symfonyStyle->progressAdvance(50);

        $symfonyStyle->progressFinish();

        $this->drawPlans($symfonyStyle, $proxyBonanzaPlans);

    }

    /**
     * @param ProxyBonanza $proxyBonanza
     * @return \ArrayObject|ProxyBonanzaPlan[]
     */
    private function getPlans(ProxyBonanza $proxyBonanza): \ArrayObject
    {
        $proxyBonanzaRemotePlans = $proxyBonanza->getRemotePlans();
        if (!$proxyBonanzaRemotePlans->count()) {
            return $proxyBonanzaRemotePlans;
        }

        return $proxyBonanzaRemotePlans;
    }

    /**
     * @param SymfonyStyle $symfonyStyle
     * @param \ArrayObject|ProxyBonanzaPlan[] $proxyBonanzaPlans
     */
    private function drawPlans(SymfonyStyle $symfonyStyle, \ArrayObject $proxyBonanzaPlans)
    {
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

        foreach ($proxyBonanzaPlans as $bonanzaPlan) {
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

}
