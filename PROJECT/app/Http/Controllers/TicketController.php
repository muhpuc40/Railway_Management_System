<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Train; // Assuming Train is your model
use App\Models\Seat; // Assuming Seat is your model

class TicketController extends Controller
{
    // Show the purchase ticket page
    public function showPurchasePage(Request $request)
    {
        // Get journey details from the request query parameters
        $journeyDetails = $request->all();

        // Pass the journey details to the view
        return view('user.purchase_ticket', ['journeyDetails' => $journeyDetails]);
    }

}


