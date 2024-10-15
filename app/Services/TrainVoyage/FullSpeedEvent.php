<?php

namespace App\Services\TrainVoyage;

class FullSpeedEvent extends TrainEvent {

    public function __construct() {
        parent::__construct(200, 200);
    }

}

