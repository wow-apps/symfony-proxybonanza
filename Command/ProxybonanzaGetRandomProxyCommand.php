<?php

namespace Wowapps\ProxyBonanzaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Wowapps\ProxyBonanzaBundle\Service\ProxyBonanza;
use Wowapps\ProxyBonanzaBundle\Traits\HelperTrait;

class ProxybonanzaGetRandomProxyCommand extends ContainerAwareCommand
{
    use HelperTrait;

    protected function configure()
    {
        $this
            ->setName('proxybonanza:random')
            ->setDescription('View random proxy')
        ;
    }

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
