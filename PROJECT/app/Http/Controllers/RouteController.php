<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    
    public function createRoute()
    {
        return view('Admin.create_route');
    }

    public function showRoute()
    {
        $routes = DB::table('routes')->get();
        return view('Admin.show_route', ['routes' => $routes]);
    }

    public function storeRoute(Request $req)
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

}
