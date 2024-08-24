<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function showAvailability(Request $request) // Inject the Request object here
    {
        $fromStation = $request->input('fromStation');
        $toStation = $request->input('toStation');
        $dateOfJourney = $request->input('dateOfJourney');

        // Fetch the trains based on the input (mock data used here)
        $trains = [
            [
                'name' => 'Train A',
                'code' => 'TA123',
                'departure_time' => '08:00 AM',
                'departure_station' => $fromStation,
                'arrival_time' => '12:00 PM',
                'arrival_station' => $toStation,
                'tickets' => [
                    ['class' => 'First Class', 'price' => 500, 'available' => 20],
                    ['class' => 'Second Class', 'price' => 300, 'available' => 50],
                ],
            ],
            // Add more train data as needed
        ];

        // Pass data to the view
        return view('user.train-availability', compact('fromStation', 'toStation', 'dateOfJourney', 'trains'));
    }
}
