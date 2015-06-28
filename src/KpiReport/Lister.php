<?php

namespace KpiReport;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Lister
{
    /**
     * @var Finder
     */
    private $finder;

    /**
     * @param Finder $finder
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }
    /**
     * @return array
     */
    public function getList()
    {
        $list = [];
        $files = $this->finder->in('src/KpiReport/Report');
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $list[] = strtolower($file->getBasename('.php'));
        }

        return $list;
    }
}
