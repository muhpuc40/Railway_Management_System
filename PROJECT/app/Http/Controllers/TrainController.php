<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainController extends Controller
{
    public function createTrain()
    {
        $routes = DB::table('routes')->get();
        return view('Admin.create_train', ['routes' => $routes]);
    }

    public function showTrain()
    {
        $trains = DB::table('trains')->get();
        return view('Admin.show_train', ['trains' => $trains]);
    }

    public function storeTrain(Request $req)
    {
        $train = DB::table('trains')->insert([
            'name' => $req->name,
            'capacity' => $req->capacity,
            'route_id' => $req->route,
        ]);

        if ($train) {
            return redirect()->route('Create_Train')->with('success', 'Train added successfully!');
        } else {
            return redirect()->route('Create_Train')->with('error', 'Error adding train!');
        }
    }
}
