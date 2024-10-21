<?php

namespace App\Services\TrainVoyage\Traits;

class StationEvent extends TrainEvent {
    public function __construct() {
        parent::__construct(50, 5);
    }
}
