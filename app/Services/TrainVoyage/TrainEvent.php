<?php

namespace App\Services\TrainVoyage;

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


    protected function calculateTime($speed, $distance):int
    {
        if ($speed <= 0) {
            throw new \InvalidArgumentException('Speed must be greater than zero.');
        }

        return ($distance / $speed) * 3600;
    }

    public function calculateEventTime():int
    {
        return $this->calculateTime($this->speed, $this->distance);
    }
}
