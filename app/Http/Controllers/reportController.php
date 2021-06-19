<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class reportController extends Controller
{
    public function reportPDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
          
        $pdf = PDF::loadView('admin.report.report', $data);
    
        return $pdf->download('report.pdf');
    }
}
