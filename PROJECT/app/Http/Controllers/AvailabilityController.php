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
        $fromStation = $request->input('fromStation', 'Kamalapur');
        $toStation = $request->input('toStation', 'Chittagong');
        $dateOfJourney = $request->input('dateOfJourney', '2024-09-01');

        // Fetch trains and their stopages from the database
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
            // Find the departure and arrival stops
            $departure = $train->stopages->firstWhere('source_station', $fromStation);
            $arrival = $train->stopages->firstWhere('source_station', $toStation);

            if ($departure && $arrival) {
                // Fetch fare information for this train
                $fares = Fare::where('train_id', $train->id)
                    ->where('source_id', $departure->id)
                    ->where('destination_id', $arrival->id)
                    ->get();

                    $tickets = $fares->map(function ($fare) use ($train) {
                        // Fetch available seats from train_details
                        $trainDetail = DB::table('train_details')
                            ->where('train_id', $train->id)
                            ->where('class', $fare->class)
                            ->first();

                    $capacity = $trainDetail->capacity ?? 0;
                    $bookedSeats = [1, 2, 3]; // Replace this with the actual booked seats logic
                    $availableSeats = $capacity - count($bookedSeats);

                    return [
                        'class' => $fare->class,
                        'price' => $fare->fare,
                        'available' => $trainDetail ? $trainDetail->capacity : 0, // Capacity from train_details
                        'bookedSeats' => [1, 2, 3], // This should be dynamic, replace with your logic
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

            return null;
        })->filter(); // Remove null values

        // Pass data to the view
        return view('user.train-availability', compact('fromStation', 'toStation', 'dateOfJourney', 'trains'));
    }
}
