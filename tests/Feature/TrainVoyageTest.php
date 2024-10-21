<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TrainVoyage\TrainVoyage;

class TrainVoyageTest extends TestCase
{
    /**
     * Test the total time calculation with a specific event string
     */
    public function test_calculate_total_time()
    {
        // Example input
        $distance = 1060;
        $eventString = 'T_T__P__P__NNN__N_T';

        // Create the TrainVoyage instance with  oarams
        $trainVoyage = new TrainVoyage($distance, $eventString);

        // Calculate total time
        $totalTime = $trainVoyage->calculateTotalTime();

        $expectedTotalTime = 41040;
        $this->assertEquals($expectedTotalTime, $totalTime);
    }
}
