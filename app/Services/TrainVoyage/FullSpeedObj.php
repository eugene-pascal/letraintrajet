<?php

namespace App\Services\TrainVoyage;

class FullSpeedObj {
    private int $speed = 200;

    public function getPassedTime($distance):float
    {
        return ($distance / $this->speed) * 3600;
    }
}

