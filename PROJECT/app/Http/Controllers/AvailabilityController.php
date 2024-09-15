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
        
            // Only proceed if both departure and arrival stations are valid
            if ($departure && $arrival) {
                // Fetch fare information for this train and route where the source and destination IDs match
                $fares = Fare::where('train_id', $train->id)
                    ->where('source_id', $departure->id)  // Match the source station
                    ->where('destination_id', $arrival->id)  // Match the destination station
                    ->get();
            
                // Only proceed if fares exist for the matching source and destination stations
                if ($fares->isNotEmpty()) {
                    $tickets = $fares->map(function ($fare) use ($train) {
                        // Fetch all train details without restricting by class
                        $trainDetails = DB::table('train_details')
                            ->where('train_id', $train->id)
                            ->get();
            
                        // Group fares by class for easy lookup
                        $faresByClass = Fare::where('train_id', $train->id)
                            ->get()
                            ->keyBy('class');  // Group fares by class for easier lookup by class name
            
                        $availableSeatsByClass = $trainDetails->groupBy('class')->map(function ($details) {
                            return $details->sum('capacity');  // Sum the capacity for each class
                        });
            
                        return [
                            'class' => $fare->class,
                            'fare' => $fare->fare,  // Default fare associated with the selected class
                            'available' => $availableSeatsByClass->get($fare->class) ?? 0,
                            'coaches' => $trainDetails->map(function ($detail) use ($faresByClass) {
                                // Find the specific fare for the coach's class
                                $coachFare = $faresByClass->get($detail->class);
            
                                return [
                                    'coach' => $detail->coach,
                                    'seats' => $detail->capacity,
                                    'bookedSeats' => [],  // Placeholder for booked seats
                                    'coach_class' => $detail->class,
                                    'fare' => $coachFare ? $coachFare->fare : null,  // Assign fare specific to the coach class
                                ];
                            })->toArray(),
                        ];
                    });
            
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
            }
            return null; // Return null if either departure or arrival is invalid
        })->filter(); // Filter out any null values
        
        // Passing data to the view
        return view('user.train-availability', compact('fromStation', 'toStation', 'dateOfJourney', 'trains'));
        
        
        
    }
}
