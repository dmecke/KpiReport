<?php

namespace KpiReport\Command;

use KpiReport\Sender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendCommand extends Command
{
    /**
     * @var Sender
     */
    private $sender;

    protected function configure()
    {
        $this->setName('report:send');
        $this->setDescription('Sends a report');
        $this->addArgument('subject', InputArgument::REQUIRED);
        $this->addArgument('report', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('sending report...');
        $this->sender->send($input->getArgument('subject'), $input->getArgument('report'));
        $output->writeln('done!');
    }

    /**
     * @param Sender $sender
     */
    public function setSender(Sender $sender)
    {
        $this->sender = $sender;
    }
}
