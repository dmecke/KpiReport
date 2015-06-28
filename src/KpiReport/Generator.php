<?php

namespace KpiReport;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Generator
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
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
        /** @var Report $report */
        $report = new $class();

        return $this->twig->render($reportName . '.html.twig', $report->getParams());
    }
}
