<?php

namespace App\Http\Controllers;
use App\Models\History;
use App\Models\user;
use App\Models\Room;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class historyController extends Controller
{
    public function index()
    {
        $history=[];
        $history['history'] = History::select('history.*', 'users.name as nameuser')
            ->join('users','users.id','=','history.id_user')->get();
        $history['history'] = History::select('history.*', 'room.name as nameroom')
            ->join('room','room.id','=','history.id_room')->get();
        $history['history'] = History::select('history.*', 'device.name as namedevice')
            ->join('device','device.id','=','history.id_device')->get();
        $history['user']=DB::table('users')->get();
        $history['room']=DB::table('room')->get();
        $history['device']=DB::table('device')->get();
        return view('admin/history/listhistory',['history'=>$history]);
    }
}
