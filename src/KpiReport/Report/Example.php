<?php

namespace KpiReport\Report;

use KpiReport\Report;

class Example implements Report
{
    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'revenue' => 1234,
        ];
    }
}
