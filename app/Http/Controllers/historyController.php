<?php

namespace App\Http\Controllers;

use App\Models\History;
class historyController extends Controller
{
    public function index()
    {
        $history=[];
        $history['history'] = History::select('history.*', 'users.name as nameuser','zone.name as namezone','room.room_name as nameroom')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['history.check_out' => 1])->paginate(10)->withQueryString();
            
        return view('admin.history.history',['history'=>$history]);
    }
}
