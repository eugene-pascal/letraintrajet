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

    public function calculateTotalTime():int {
        $totalTime = [];
        $distanceCoveredInKm = [];

        $totalEvents = $this->events->count();

        $this->events->each(function ($eventChar, $iterCollection) use (&$totalTime, &$distanceCoveredInKm, $totalEvents) {
            $event = $this->getEventClass($eventChar);
            $key = '_' === $eventChar ? '200' : $eventChar;
            if (!isset($totalTime[$key])) {
                $totalTime[$key] = 0;
                $distanceCoveredInKm[$key] = 0;
            }
            $totalTime[$key] += $event->calculateEventTime();
            $distanceCoveredInKm[$key] += $event->getPassedDistance();

            if ('T' === $key && !in_array($iterCollection, [0,$totalEvents-1])) {
                $totalTime[$key] += $event->calculateEventTime();
                $distanceCoveredInKm[$key] += $event->getPassedDistance();
            }
        });

        $allKmExcept200 = collect($distanceCoveredInKm)
            ->filter(function ($value) {
                return is_numeric($value);
            })
            ->sum();

        $fullSpeedEventModel = new FullSpeedEvent(200, $this->distance - $allKmExcept200);
        $totalTime[200] = $fullSpeedEventModel->calculateEventTime();
        $distanceCoveredInKm[200] = $fullSpeedEventModel->getPassedDistance();

        return collect($totalTime)->sum();
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
