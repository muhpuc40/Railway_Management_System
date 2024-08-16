<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
//use PDF;

class PdfController extends Controller
{
    public function downloadFarePdf()
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
        $time = now();

        // Load the view and pass the data
        $pdf = Pdf::loadView('pdf.fare_pdf', compact('groupedFares', 'classes','time'));

        // Return the PDF as a download
        return $pdf->download('train_fares.pdf');
    }

public function generateTicket()
{
    // Path to the images
  //  $logoPath = public_path('images/logo.png');
   // $bdLogoPath = public_path('images/bd.png');

    // Convert images to base64
   // $logoBase64 = base64_encode(file_get_contents($logoPath));
   // $bdLogoBase64 = base64_encode(file_get_contents($bdLogoPath));
   $qrcode = base64_encode(QrCode::format('svg')                                
                                    ->size(100)
                                    ->errorCorrection('H')                                
                                    ->generate('Minhaj'));
    // Sample data for the PDF
    $data = [
        'issue_date' => '05-01-2024 08:55',
        'journey_date' => '06-01-2024 18:00',
        'train_name' => 'MEGHNA EXPRESS [729]',
        'from_station' => 'Chattogram',
        'to_station' => 'Feni',
        'class_name' => 'SHOVAN',
        'coach_seat' => 'SCHA-26',
        'num_seats' => 1,
        'num_adult' => 1,
        'num_child' => 0,
        'fare' => 'BDT 90.00',
        'vat' => 'BDT 0.00',
        'service_charge' => 'BDT 20.00',
        'total_fare' => 'BDT 110.00',
        'passenger_name' => 'Minhaj U Hassan',
        'id_type' => 'NID',
        'id_number' => '5066714873',
        'mobile_number' => '01717172939',
        'pnr_number' => '65976F9F1B793',
        'qrcode' => $qrcode,
        'time' => now()
      //  'logoBase64' => $logoBase64,
       // 'bdLogoBase64' => $bdLogoBase64
    ];

    // Load the view and pass the data
    $pdf = PDF::loadView('pdf.ticket', $data);

    
    $filename =  $data['passenger_name'] . ' Train-Ticket.pdf';

    // Optionally stream or download the PDF
    return $pdf->download($filename);
}

}
