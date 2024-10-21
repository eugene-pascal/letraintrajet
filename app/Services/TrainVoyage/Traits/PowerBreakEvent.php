<?php

namespace App\Services\TrainVoyage\Traits;

class PowerBreakEvent extends TrainEvent{
    public function __construct()
    {
        parent::__construct(5, 10);
    }
}
