<?php

namespace App\Http\Controllers;

use App\Services\TrainVoyage\TrainVoyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function trainVoyage(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'distance' => 'required|integer',
            'events' => [
                'required',
                'string',
                'regex:/^([TNP\_])+$/'
            ],
        ], [
            'distance.required' => 'Distance value is required.',
            'events.required' => 'Route value is required.',
            'events.regex' => 'The event pattern is invalid. It should only contain T, N, P, and underscores (_).'
        ]);

        if ($validatedData->fails()) {
            dd($validatedData->errors());
        }

        $distance = (int)$request->input('distance');
        $events = $request->input('events');

        $trip = New TrainVoyage($distance, $events);

        return view('task.trainVoyage', ['total' => $trip->calculateTotalTime()]);
    }
}
