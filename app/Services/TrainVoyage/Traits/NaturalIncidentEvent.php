<?php

namespace App\Services\TrainVoyage\Traits;

class NaturalIncidentEvent extends TrainEvent {
    public function __construct()
    {
        parent::__construct(10, 5);
    }
}
