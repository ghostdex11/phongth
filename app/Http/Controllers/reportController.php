<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\History;
use PDF;
class reportController extends Controller
{
    public function reportPDF()
    {
        $data = Computer::select('computer.*','room.room_name as roomname')
        ->join('room','room.id','=','computer.id_room')->where(['computer.activity' => 0])->get();
        $pdf = \PDF::loadView('admin.report.report', compact('data'));
        return $pdf->stream('report-computer.pdf');
    }
    public function reporthistoryPDF()
    {
        $data = History::select('history.*', 'users.name as nameuser','zone.name as namezone','room.room_name as nameroom')
        ->join('users','users.id','=','history.id_user')
        ->join('zone','zone.id','=','history.id_zone')
        ->join('room','room.id','=','history.id_room')
        ->join('device','device.id','=','history.id_device')
        ->where(['history.check_out' => 1])->get();
        $pdf = \PDF::loadView('admin.report.reporthistory', compact('data'));
        return $pdf->stream('report-history.pdf');
    }
}
