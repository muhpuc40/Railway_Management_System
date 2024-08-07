<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Fare;

class FareController extends Controller
{
    public function createFare($train_id)
    {
        // Retrieve train details including the name
        $train = DB::table('train_list')->find($train_id);

        // Retrieve all stoppages for the given train
        $trainRoutes = DB::select("
            SELECT 
                a.id AS id1, 
                a.train_id AS train_id1, 
                a.schedule_id AS schedule_id1, 
                a.source_station AS source_station1, 
                a.sequence AS sequence1, 
                a.time AS time1, 
                b.id AS id2, 
                b.train_id AS train_id2, 
                b.schedule_id AS schedule_id2, 
                b.source_station AS source_station2, 
                b.sequence AS sequence2, 
                b.time AS time2
            FROM 
                train_stopage a
            JOIN 
                train_stopage b 
            ON 
                a.schedule_id = b.schedule_id AND 
                a.sequence < b.sequence
            WHERE 
                a.train_id = ?
            ORDER BY 
                a.schedule_id, a.sequence, b.sequence
        ", [$train_id]);

        // Retrieve the classes for the train
        $trainDetails = DB::table('train_details')
            ->where('train_id', $train_id)
            ->get(['class'])
            ->pluck('class')
            ->unique()
            ->toArray();

        // Check if fares are already inputted for this train
        $fares = Fare::where('train_id', $train_id)->get()->groupBy(['source_id', 'destination_id', 'class']);

        return view('admin.create_fare', compact('trainRoutes', 'trainDetails', 'train_id', 'train', 'fares'));
    }

    public function storeFare(Request $req)
    {
        \Log::info($req->all()); // Log the request data

        DB::beginTransaction();
        try {
            $train_id = $req->train_id;

            foreach ($req->fares as $route => $classes) {
                list($source_id, $destination_id) = explode('_', $route);
                foreach ($classes as $class => $fare) {
                    if ($fare !== null) {
                        Fare::create([
                            'train_id' => $train_id,
                            'source_id' => $source_id,
                            'destination_id' => $destination_id,
                            'class' => $class,
                            'fare' => $fare,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('Show_Train')->with('success', 'Fares added successfully!');
        } catch (\Exception $e) {
            \Log::error($e); // Log the exception
            DB::rollback();
            return redirect()->route('create_fare', ['train_id' => $train_id])->with('error', 'Error adding fares!');
        }
    }

    public function showFare()
    {

        // Retrieve all distinct classes from train_details
        $classes = DB::table('train_details')->distinct()->pluck('class')->toArray();

        // Retrieve all fares with necessary joins
        $fares = DB::table('fares')
            ->join('train_list', 'fares.train_id', '=', 'train_list.id')
            ->join('train_stopage as source', 'fares.source_id', '=', 'source.id')
            ->join('train_stopage as destination', 'fares.destination_id', '=', 'destination.id')
            ->select(
                'train_list.name as train_name',
                'source.source_station as source_station',
                'destination.source_station as destination_station',
                'fares.class',
                'fares.fare'
            )
            ->get();

        // Group the fares by train_name and stopage
        $groupedFares = [];
        foreach ($fares as $fare) {
            $stopageKey = "{$fare->source_station} to {$fare->destination_station}";
            $groupedFares[$fare->train_name][$stopageKey][$fare->class] = $fare->fare;
        }

        return view('admin.show_fare', compact('groupedFares', 'classes'));
    }
    public function updateFare(Request $req, $train_id)
    {
        DB::beginTransaction();
        try {
            // Iterate through the provided fares
            foreach ($req->fares as $route => $classes) {
                list($source_id, $destination_id) = explode('_', $route);
                foreach ($classes as $class => $fare) {
                    if ($fare !== null) {
                        // Check if the fare already exists
                        $existingFare = Fare::where([
                            ['train_id', '=', $train_id],
                            ['source_id', '=', $source_id],
                            ['destination_id', '=', $destination_id],
                            ['class', '=', $class],
                        ])->first();
    
                        if ($existingFare) {
                            // Update the existing fare
                            $existingFare->update(['fare' => $fare]);
                        } else {
                            // Create a new fare
                            Fare::create([
                                'train_id' => $train_id,
                                'source_id' => $source_id,
                                'destination_id' => $destination_id,
                                'class' => $class,
                                'fare' => $fare,
                            ]);
                        }
                    }
                }
            }
    
            DB::commit();
            return redirect()->route('show_fare')->with('success', 'Fares updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('create_fare', ['train_id' => $train_id])->with('error', 'Update Gora nojar!');
        }
    }
    

}