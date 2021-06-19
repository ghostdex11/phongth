<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class reportController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
          
        $pdf = PDF::loadView('report.report', $data);
    
        return $pdf->download('brokencomputer.pdf');
    }
}
