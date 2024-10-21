<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class trainVoyage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'train:voyage {distance} {--route=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle train voyage calculations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $distance = $this->argument('distance');

        $route = $this->option('route');

        $trip = New \App\Services\TrainVoyage\TrainVoyage($distance, $route);

        // Your logic here
        $this->info('Train voyage takes in sec: '.$trip->calculateTotalTime());

        // Return 0 to indicate success
        return 0;
    }
}
