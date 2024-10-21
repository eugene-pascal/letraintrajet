<?php

namespace App\Services\TrainVoyage\Traits;

abstract class TrainEvent {
    protected int $speed;
    protected int $distance;

    public function __construct(int $speed, int $distance)
    {
        $this->speed = $speed;
        $this->distance = $distance;
    }

    public function getPassedDistance():int
    {
        return $this->distance;
    }

    protected function calculateTime($speed, $distance):float
    {
        if ($speed <= 0) {
            throw new \InvalidArgumentException('Speed must be greater than zero.');
        }
        return ($distance / $speed) * 3600;
    }

    public function calculateEventTime():float
    {
        return $this->calculateTime($this->speed, $this->distance);
    }
}
