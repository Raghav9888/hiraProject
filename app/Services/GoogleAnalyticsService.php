<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;
use Google\ApiCore\ValidationException;

class GoogleAnalyticsService
{
    protected $propertyId;
    protected $client;

    /**
     * @throws ValidationException
     */
    public function __construct()
    {
        $this->propertyId = config('analytics.property_id', 'YOUR_DEFAULT_PROPERTY_ID'); // fallback just in case

        $this->client = new BetaAnalyticsDataClient([
            'credentials' => storage_path('app/google/analytics/credential.json')
        ]);
    }

    public function getWeeklyReport()
    {
        $today = now()->toDateString();
        $startOfThisWeek = now()->startOfWeek()->toDateString();
        $startOfLastWeek = now()->subWeek()->startOfWeek()->toDateString();
        $endOfLastWeek = now()->subWeek()->endOfWeek()->toDateString();

        // Labels (Sunday to Saturday)
        $labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $thisWeek = array_fill(0, 7, 0);
        $lastWeek = array_fill(0, 7, 0);

        // This week report
        $thisWeekResponse = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dimensions' => [new Dimension(['name' => 'dayOfWeek'])],
            'metrics' => [new Metric(['name' => 'activeUsers'])],
            'dateRanges' => [new DateRange(['start_date' => $startOfThisWeek, 'end_date' => $today])]
        ]);

        foreach ($thisWeekResponse->getRows() as $row) {
            $day = (int) $row->getDimensionValues()[0]->getValue();
            $thisWeek[$day] = (int) $row->getMetricValues()[0]->getValue();
        }

        // Last week report
        $lastWeekResponse = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dimensions' => [new Dimension(['name' => 'dayOfWeek'])],
            'metrics' => [new Metric(['name' => 'activeUsers'])],
            'dateRanges' => [new DateRange(['start_date' => $startOfLastWeek, 'end_date' => $endOfLastWeek])]
        ]);

        foreach ($lastWeekResponse->getRows() as $row) {
            $day = (int) $row->getDimensionValues()[0]->getValue();
            $lastWeek[$day] = (int) $row->getMetricValues()[0]->getValue();
        }

        return [
            'labels' => $labels,
            'thisWeek' => $thisWeek,
            'lastWeek' => $lastWeek,
        ];
    }
}
