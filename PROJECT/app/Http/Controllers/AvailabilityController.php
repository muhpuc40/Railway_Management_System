<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Train;
use App\Models\Fare;

class AvailabilityController extends Controller
{
    public function showAvailability(Request $request)
    {
        // Fetching stations and date of journey from the request
        $fromStation = $request->input('fromStation', 'Kamalapur');
        $toStation = $request->input('toStation', 'Chittagong');
        $dateOfJourney = $request->input('dateOfJourney', '2024-09-01');

        // Fetching trains with stopages that match the route
        $trains = Train::whereHas('stopages', function ($query) use ($fromStation, $toStation) {
            $query->where('source_station', $fromStation)
                  ->orWhere('source_station', $toStation);
        })
        ->with(['stopages' => function ($query) use ($fromStation, $toStation) {
            $query->whereIn('source_station', [$fromStation, $toStation])
                  ->orderBy('time');
        }])
        ->get()
        ->map(function ($train) use ($fromStation, $toStation) {
            // Find departure and arrival stops
            $departure = $train->stopages->firstWhere('source_station', $fromStation);
            $arrival = $train->stopages->firstWhere('source_station', $toStation);

            if ($departure && $arrival) {
                // Fetch fare information for this train and route
                $fares = Fare::where('train_id', $train->id)
                    ->where('source_id', $departure->id)
                    ->where('destination_id', $arrival->id)
                    ->get();

                $tickets = $fares->map(function ($fare) use ($train) {
                    // Fetch train details like coaches and seats
                    $trainDetail = DB::table('train_details')
                        ->where('train_id', $train->id)
                        ->where('class', $fare->class)
                        ->get();

                    // Replace this with the actual booked seats logic based on the real booking system
                    $bookedSeats = [1, 2, 3]; 

                    return [
                        'class' => $fare->class,
                        'price' => $fare->fare,
                        'available' => $trainDetail->sum('capacity'), // Summing up capacity of coaches
                        'bookedSeats' => $bookedSeats, // Temporary placeholder
                        'coaches' => $trainDetail->map(function ($detail) {
                            return [
                                'coach' => $detail->coach,
                                'seats' => $detail->capacity,
                                'coach_class' => $detail->class,
                            ];
                        })->toArray(),
                    ];
                });

                // Return formatted train data
                return [
                    'name' => $train->name,
                    'code' => $train->id,
                    'departure_time' => $departure->time,
                    'departure_station' => $departure->source_station,
                    'arrival_time' => $arrival->time,
                    'arrival_station' => $arrival->source_station,
                    'tickets' => $tickets,
                ];
            }

            return null;
        })->filter(); // Filtering out null values

        // Passing data to the view
        return view('user.train-availability', compact('fromStation', 'toStation', 'dateOfJourney', 'trains'));
    }
}
