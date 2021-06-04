<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;
use App\Models\Room;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class pageController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function gethome()
    {
        $home=[];
        $home['history'] = History::select('history.*', 'users.name as nameuser')
            ->join('users','users.id','=','history.id_user')->get();
        $home['history'] = History::select('history.*', 'room.name as nameroom')
            ->join('room','room.id','=','history.id_room')->get();
        $home['history'] = History::select('history.*', 'device.name as namedevice')
            ->join('device','device.id','=','history.id_device')->get();
        $home['user']=DB::table('users')->get();
        $home['room']=DB::table('room')->get();
        $home['device']=DB::table('device')->get();
        $home['zone']=DB::table('zone')->get();
        return view('user.page',['home' => $home]);
    }
    public function adddangky(Request $request)
    {

        $history=new History;
        $history->id_zone=$request->zone;
        $history->id_user=Auth::user()->id;
        $history->id_room=$request->room;
        $history->floor=$request->floor;
        $history->id_device=$request->device;
        dd($request);
        $history->save();

                return redirect('home/dangky');
    }
}
