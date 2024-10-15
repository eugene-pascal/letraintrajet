<?php

namespace App\Services\TrainVoyage;

class PowerBreakEvent extends TrainEvent {

    public function __construct() {
        parent::__construct(5, 10);
    }

}
