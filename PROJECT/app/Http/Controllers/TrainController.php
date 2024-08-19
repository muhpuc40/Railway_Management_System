<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function class()
    {
        $today = date('Y-m-d');
        $maxDate = date('Y-m-d', strtotime('+6 days'));
        $classes = DB::table('train_details')->distinct()->pluck('class');
        return view('welcome', compact('today', 'maxDate','classes'));
    }
    public function searchTrains(Request $request)
    {
        $fromStation = $request->input('fromStation');
        $toStation = $request->input('toStation');

// add korte hobee
    
        return view('user.search_trains', compact('groupedFares', 'classes'));
    }
    

    public function showSearchForm()
    {
        return view('user.search_trains');
    }


    public function createTrain()
    {
        return view('admin.create_train');
    }

    public function storeTrain(Request $req)
    {
        DB::beginTransaction();
        try {
            $train = DB::table('train_list')->insertGetId([
                'name' => $req->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($req->coaches as $index => $coach) {
                DB::table('train_details')->insert([
                    'train_id' => $train,
                    'coach' => $coach,
                    'class' => $req->classes[$index],
                    'capacity' => $req->capacities[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                    
                ]);
            }

            DB::commit();
            return redirect()->route('Show_Train')->with('success', 'Train added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('Create_Train')->with('error', 'Error adding train!');
        }
    }


    public function showTrain()
    {
        $trains = DB::table('train_list')
            ->leftJoin('train_details', 'train_list.id', '=', 'train_details.train_id')
            ->select('train_list.id', 'train_list.name', 'train_list.created_at','train_list.updated_at', DB::raw('SUM(DISTINCT train_details.capacity) as capacity'))
            ->groupBy('train_list.id', 'train_list.name', 'train_list.created_at','train_list.updated_at')
            ->get();
    
        return view('Admin.show_train', ['trains' => $trains]);
    }
    

    public function updateTrain(Request $request, $id)
{
    DB::table('train_list')
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            'updated_at' => now() // Update the updated_at column
        ]);

    return redirect()->back()->with('success', 'Train updated successfully');
}


    public function deleteTrain($id)
    {
        DB::transaction(function() use ($id) {
            // Delete from fares table
            DB::table('fares')->where('train_id', $id)->delete();
    
            // Delete from train_stopage table
            DB::table('train_stopage')->where('train_id', $id)->delete();
    
            // Delete from train_day table
            DB::table('train_day')->where('train_id', $id)->delete();
    
            // Delete from train_details table
            DB::table('train_details')->where('train_id', $id)->delete();
    
            // Finally delete from train_list table
            DB::table('train_list')->where('id', $id)->delete();
        });
    
        return redirect()->back()->with('success', 'Train deleted successfully');
    }
    
    public function trainDetails(string $id)
    {
        // Fetch train details along with route
        $train = DB::table('train_list')->where('id', $id)->first();

        //if id not found
        if (!$train) {
            abort(404);
        }
        
        // Fetch stoppages
        $stopages = DB::table('train_stopage')
            ->where('train_id', $id)
            ->orderBy('sequence')
            ->get();

        // Fetch details
        $details = DB::table('train_details')->where('train_id', $id)->get();

        // Fetch working days
        $days = DB::table('train_day')->where('train_id', $id)->first();

        // Fetch fares
        $fares = DB::table('fares')->where('train_id', $id)->get()->groupBy(['source_id', 'destination_id', 'class']);

        // Fetch class list for fares input form
        $trainDetails = $details->pluck('class')->unique()->toArray();

        // Fetch train routes for fares input form
        $trainRoutes = DB::select("
            SELECT 
                a.id AS id1, 
                a.source_station AS source_station1, 
                b.id AS id2, 
                b.source_station AS source_station2
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
                a.sequence, b.sequence
        ", [$id]);

        return view('admin.train_details', compact('train', 'stopages', 'details', 'days', 'fares', 'trainDetails', 'trainRoutes'));
    }


}