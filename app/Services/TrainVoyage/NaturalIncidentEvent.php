<?php

namespace App\Services\TrainVoyage;

class NaturalIncidentEvent extends TrainEvent {
    public function __construct()
    {
        parent::__construct(10, 5);
    }
}
