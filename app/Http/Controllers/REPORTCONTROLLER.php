<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class REPORTCONTROLLER extends Controller
{
    public function generateReport($type = 'stream')
    {
        // Example data (Replace with actual data from your database)
        $data = [
            'receipt_no' => '273',
            'vehicle_no' => 'TN 38 AC 8777',
            'date' => '12-03-2025',
            'customer_name' => 'C.M.S',
            'start_time' => '7.8.9.9.0',
            'end_time' => '7.8.9.7.10',
            'total_hours' => '7.70',
            'signatures' => ['Sujay', 'Owner'],
        ];

        $pdf = Pdf::loadView('reports.invoice', compact('data'));
        // return $pdf->stream('invoice.pdf');
        if ($type == 'download') {
            return $pdf->download('invoice.pdf'); // Force download
        }
    
        return $pdf->stream('invoice.pdf'); // View in browser
    }
}
