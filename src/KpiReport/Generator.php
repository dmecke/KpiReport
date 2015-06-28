<?php

namespace KpiReport;

use KpiReport\Report\Monthly;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

// @todo remove this class. instead, new reports should be added in a similar way as commands are added to the application (with an add method). that makes using the di container easier
class Generator
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Monthly
     */
    private $monthlyReport;

    /**
     * @param \Twig_Environment $twig
     * @param Monthly $monthlyReport
     */
    public function __construct(\Twig_Environment $twig, Monthly $monthlyReport)
    {
        $this->twig = $twig;
        $this->monthlyReport = $monthlyReport;
    }

    /**
     * @param string $reportName
     *
     * @return string
     */
    public function generate($reportName)
    {
        $class = 'KpiReport\\Report\\' . ucfirst($reportName);
        if (!class_exists($class)) {
            throw new FileNotFoundException('Could not find report "' . $class . '"');
        }
        if ($reportName == 'monthly') { // @todo remove this special case by handling all reports via dependency injection
            $report = $this->monthlyReport;
        } else {
            /** @var Report $report */
            $report = new $class();
        }

        return $this->twig->render($reportName . '.html.twig', $report->getParams());
    }
}
