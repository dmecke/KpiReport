<?php

namespace KpiReport\Command;

use KpiReport\Lister;
use KpiReport\Sender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    /**
     * @var Lister
     */
    private $lister;

    protected function configure()
    {
        $this->setName('report:list');
        $this->setDescription('Lists all available reports');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $availableReports = $this->lister->getList();
        foreach ($availableReports as $report) {
            $output->writeln($report);
        }
    }

    /**
     * @param Lister $lister
     */
    public function setLister(Lister $lister)
    {
        $this->lister = $lister;
    }
}
