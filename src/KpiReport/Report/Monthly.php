<?php

namespace KpiReport\Report;

use KeenIO\Client\KeenIOClient;
use KpiReport\Report;

class Monthly implements Report
{
    /**
     * @var KeenIOClient
     */
    private $client;

    /**
     * @param string $projectId
     * @param string $readKey
     */
    public function __construct($projectId, $readKey)
    {
        $this->client = KeenIOClient::factory([
            'projectId' => $projectId,
            'readKey' => $readKey,
        ]);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $date = new \DateTime('yesterday');

        return [
            'date' => $date->format('F Y'),
            'classic_mau' => $this->getMau('classic'),
            'classic_signups' => $this->getSignups('classic'),
            'classic_revenue' => $this->getRevenue('classic'),
            'speed_mau' => $this->getMau('speed'),
            'speed_signups' => $this->getSignups('speed'),
            'speed_revenue' => $this->getRevenue('speed'),
        ];
    }

    /**
     * @param string $tour
     *
     * @return array
     */
    private function getMau($tour)
    {
        return $this->getCountUnique($tour, 'login', 'monthly');
    }

    /**
     * @param string $tour
     *
     * @return array
     */
    private function getSignups($tour)
    {
        return $this->getCountUnique($tour, 'signup', 'monthly');
    }

    /**
     * @param string $tour
     *
     * @return array
     */
    private function getRevenue($tour)
    {
        return $this->getSum($tour, 'payment', 'monthly');
    }

    /**
     * @param string $tour
     * @param string $metric
     * @param int $interval
     *
     * @return array
     */
    private function getCountUnique($tour, $metric, $interval)
    {
        $result = $this->client->countUnique(
            $metric,
            [
                'target_property' => 'user.id',
                'filters' => [['property_name' => 'tour', 'operator' => 'eq', 'property_value' => $tour]],
                'timeframe' => 'previous_2_month',
                'interval' => $interval,
            ]
        );
        $values = [];
        foreach ($result['result'] as $row) {
            $values[] = $row['value'];
        }

        $last = $values[0];
        $current = $values[1];

        return [
            'current' => $current,
            'change' => $current - $last,
        ];
    }

    /**
     * @param string $tour
     * @param string $metric
     * @param int $interval
     *
     * @return array
     */
    private function getSum($tour, $metric, $interval)
    {
        $result = $this->client->sum(
            $metric,
            [
                'target_property' => 'euro_value',
                'filters' => [['property_name' => 'tour', 'operator' => 'eq', 'property_value' => $tour]],
                'timeframe' => 'previous_2_month',
                'interval' => $interval,
            ]
        );
        $values = [];
        foreach ($result['result'] as $row) {
            $values[] = $row['value'];
        }

        $last = $values[0];
        $current = $values[1];

        return [
            'current' => $current,
            'change' => $current - $last,
        ];
    }
}
