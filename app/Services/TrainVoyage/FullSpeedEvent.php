<?php

namespace App\Services\TrainVoyage;

class FullSpeedEvent extends TrainEvent {
    public function __construct(int $speed = 200, int $distance = 0)
    {
        parent::__construct($speed, $distance);
    }
}

