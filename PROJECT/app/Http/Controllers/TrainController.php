<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainController extends Controller
{
    public function createt()
    {

        $routes = DB::table('routes')->get();
        return view('Admin.create_train', ['routes' => $routes]);
    }

    public function creater()
    {
        return view('Admin.create_route');
    }

    public function create_route(Request $req)
    {
        $user = DB::table('routes')->insert([
            'source' => $req->source,
            'destination' => $req->destination,
            'distance' => $req->distance,
            'duration' => $req->duration,
        ]);

        if ($user) {
            return redirect()->route('Create_Route')->with('success', 'Data added successfully!');
        } else {
            return redirect()->route('Create_Route')->with('error', 'Error adding data!');
        }
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
