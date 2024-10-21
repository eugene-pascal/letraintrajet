<?php
namespace App\Services\TrainVoyage;

use App\Services\TrainVoyage\Traits\NaturalIncidentEvent;
use App\Services\TrainVoyage\Traits\PowerBreakEvent;
use App\Services\TrainVoyage\Traits\StationEvent;
use App\Services\TrainVoyage\Traits\TrainEvent;
use Illuminate\Support\Collection;

class TrainVoyage {
    private int $distance;
    private Collection $events;
    private string $nameAction;

    public function __construct($distance, $eventString) {
        $this->distance = $distance;
        // Convert each character into its corresponding event class
        $this->events = collect(str_split($eventString))
            ->map(function($eventChar) {
                // Ignore "_" (200 km) because it is not event
                if ($eventChar === '_') {
                    return null;
                }
                return $this->getEventClass($eventChar);
            })
            ->reject(function($event) {
                // Remove null values
                return is_null($event);
            })
            ->values();
    }

    private function itNeedsIn(string $name) {
        if (!in_array($name,['distance','time'])) {
            throw new \InvalidArgumentException("Unknown event type: $eventChar");
        }
        $this->nameAction =  $name;
        return $this;
    }

    private function getDataOfEvent(TrainEvent $event, bool $isEventNeitherFirstNorLast):float {
        if ('distance' === $this->nameAction) {
            $methodName = 'getPassedDistance';
        }
        elseif ('time' === $this->nameAction) {
            $methodName = 'calculateEventTime';
        }
        // detect all StationEvent events except the first and the last
        if ($event instanceof StationEvent && $isEventNeitherFirstNorLast) {
            return $event->$methodName() * 2;
        }
        return $event->$methodName();
    }

    private function getPassedTimeOnEvents():float
    {
        $timePassed = 0;
        $totalEvents = $this->events->count();
        $this->events->each(function ($event, $iterCollection) use (&$timePassed, $totalEvents) {
            $timePassed += $this
                ->itNeedsIn('time')
                ->getDataOfEvent($event, !in_array($iterCollection, [0,$totalEvents-1]) );
        });
        return $timePassed;
    }

    private function getPassedDistancesOnEvents():float
    {
        $distancePassed = 0;
        $totalEvents = $this->events->count();
        $this->events->each(function ($event, $iterCollection) use (&$distancePassed, $totalEvents) {
            $distancePassed += $this
                ->itNeedsIn('distance')
                ->getDataOfEvent($event, !in_array($iterCollection, [0,$totalEvents-1]) );
        });
        return $distancePassed;

    }

    private function getEventClass($eventChar): TrainEvent {
        switch ($eventChar) {
            case 'T':
                return new StationEvent();
            case 'P':
                return new PowerBreakEvent();
            case 'N':
                return new NaturalIncidentEvent();
            default:
                throw new \InvalidArgumentException("Unknown event type: $eventChar");
        }
    }

    public function calculateTotalTime():float {
        $fullSpeedEventModel = new FullSpeedObj();
        return $this->getPassedTimeOnEvents() +
            $fullSpeedEventModel->getPassedTime( $this->distance - $this->getPassedDistancesOnEvents() );
    }
}
