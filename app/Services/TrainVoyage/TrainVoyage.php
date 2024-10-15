<?php

namespace App\Services\TrainVoyage;
use Illuminate\Support\Collection;

class TrainVoyage {
    private int $distance;
    private $events;

    public function __construct($distance, $eventString) {
        $this->distance = $distance;
        $this->events = collect(str_split($eventString));
    }

    public function calculateTotalTime():array {
        $totalTime = 0;
        $distanceCoveredInKm = 0;

        foreach ($this->events as $eventChar) {
            $event = $this->getEventClass($eventChar);

            // Calculate the time for current event
            $totalTime += $event->calculateEventTime();
            $distanceCoveredInKm += $event->getPassedDistance();
            echo $eventChar.'===> time: '.$event->calculateEventTime().' , passed km '. $event->getPassedDistance().'<br>';

            if ($distanceCoveredInKm >= $this->distance) {
//                break;
            }
        }
        return [$totalTime, $distanceCoveredInKm];
    }

    private function getEventClass($eventChar): TrainEvent {
        switch ($eventChar) {
            case 'T':
                return new StationEvent();
            case 'P':
                return new PowerBreakEvent();
            case 'N':
                return new NaturalIncidentEvent();
            case '_':
                return new FullSpeedEvent();
            default:
                throw new \InvalidArgumentException("Unknown event type: $eventChar");
        }
    }
}
