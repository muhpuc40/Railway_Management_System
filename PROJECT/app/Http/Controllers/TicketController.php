<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Show the purchase ticket page
    public function showPurchasePage()
    {
        // You can pass necessary data to the view if needed.
        return view('User.purchase_ticket');
    }

    // Process the ticket form submission
    public function processTicket(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'passenger1' => 'required|string|max:255',
            'passenger2' => 'nullable|string|max:255',
            'passengerType1' => 'required',
            'passengerType2' => 'nullable',
            'mobile' => 'required|string|min:11|max:15',
        ]);

        // Process the form inputs and save them to the database or take appropriate action
        // For example, you could store the data in a table

        // After processing, you can redirect or return a success message
        return redirect()->back()->with('success', 'Ticket booking processed successfully!');
    }
}
