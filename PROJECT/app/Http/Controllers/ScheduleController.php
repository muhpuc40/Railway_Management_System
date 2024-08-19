<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Models\Stopage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function createSchedule($train_id)
    {
        $train = DB::table('train_list')->find($train_id);
        
        //if id not found
        if (!$train) {
            abort(404);
        }


        // Fetch existing schedule details
        $days = DB::table('train_day')->where('train_id', $train_id)->first();
        $stopages = DB::table('train_stopage')
            ->where('train_id', $train_id)
            ->orderBy('sequence')
            ->get();

        return view('admin.create_schedule', compact('train', 'days', 'stopages'));
    }

    public function storeSchedule(Request $req)
    {
        DB::beginTransaction();
        try {
            $train_id = $req->train_id;

            // Delete old schedule if it exists
            DB::table('train_day')->where('train_id', $train_id)->delete();
            DB::table('train_stopage')->where('train_id', $train_id)->delete();

            // Store selected days in the train_day table
            $schedule_id = DB::table('train_day')->insertGetId([
                'train_id' => $train_id,
                'saturday' => in_array('saturday', $req->days) ? 1 : 0,
                'sunday' => in_array('sunday', $req->days) ? 1 : 0,
                'monday' => in_array('monday', $req->days) ? 1 : 0,
                'tuesday' => in_array('tuesday', $req->days) ? 1 : 0,
                'wednesday' => in_array('wednesday', $req->days) ? 1 : 0,
                'thursday' => in_array('thursday', $req->days) ? 1 : 0,
                'friday' => in_array('friday', $req->days) ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Store stopages and time in the train_stopage table
            foreach ($req->stopages as $index => $stopage) {
                DB::table('train_stopage')->insert([
                    'train_id' => $train_id,
                    'schedule_id' => $schedule_id,
                    'source_station' => $stopage['source_station'],
                    'sequence' => $index + 1,
                    'time' => $stopage['time'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return redirect()->route('show_train')->with('success', 'Schedule added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('create_schedule', ['train_id' => $train_id])->with('error', 'Error adding schedule!');
        }
    }

    public function showSchedule()
    {
        $trains = DB::table('train_list')->get();

        $schedules = [];

        foreach ($trains as $train) {
            $days = DB::table('train_day')->where('train_id', $train->id)->first();
            $stopages = DB::table('train_stopage')
                ->where('train_id', $train->id)
                ->orderBy('sequence')
                ->get();

            $schedules[] = [
                'train' => $train,
                'days' => $days,
                'stopages' => $stopages->isEmpty() ? collect() : $stopages,
            ];
        }

        return view('admin.show_schedule', compact('schedules'));
    }

    public function updatesc(Request $request, $train_id)
    {
        // Validate input
        $request->validate([
            'stopages.*.source_station' => 'required|string',
            'stopages.*.time' => 'required|string',
            'days' => 'array',
        ]);
    
        DB::beginTransaction();
        try {
            // Fetch the existing schedule_id for the given train_id
            $schedule_id = DB::table('train_day')->where('train_id', $train_id)->value('id');
            
            // Update or create stopages
            foreach ($request->input('stopages', []) as $index => $stopageData) {
                DB::table('train_stopage')->updateOrInsert(
                    [
                        'train_id' => $train_id,
                        'schedule_id' => $schedule_id,
                        'sequence' => $index + 1,
                    ],
                    [
                        'source_station' => $stopageData['source_station'],
                        'time' => $stopageData['time'],
                        'updated_at' => now(),
                    ]
                );
            }
    
            // Update days
            $daysData = [];
            foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
                $daysData[$day] = in_array($day, $request->input('days', [])) ? 1 : 0;
            }
    
            DB::table('train_day')->where('id', $schedule_id)->update($daysData);
    
            DB::commit();
            return redirect()->route('show_train')->with('success', 'Schedule updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('create_schedule', ['train_id' => $train_id])->with('error', 'Error updating schedule!');
        }
    }
    

    
}
