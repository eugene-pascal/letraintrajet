<?php

namespace App\Services\TrainVoyage;

class NaturalIncidentEvent extends TrainEvent
{
    public function __construct()
    {
        // 10km/h pendent 5km
        parent::__construct(10, 5);
    }

}
