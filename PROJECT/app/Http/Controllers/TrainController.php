<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    //

    public function createt(){
        return view('Admin.create_train');
    }
    public function creater(){
        return view('Admin.create_route');
    }


}
