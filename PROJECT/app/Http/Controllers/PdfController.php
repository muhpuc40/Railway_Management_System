<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
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

        // Load the view and pass the data
        $pdf = Pdf::loadView('pdf.fare_pdf', compact('groupedFares', 'classes'));

        // Return the PDF as a download
        return $pdf->download('train_fares.pdf');
    }
}
