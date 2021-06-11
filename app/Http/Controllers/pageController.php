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
    public function indexRoom()
    {
        return view('user.page');
    }
    public function gethome()
    {
        $home=[];
        $home['history'] = History::select('history.*', 'users.name as nameuser' , 'room.name as nameroom', 'zone.name as namezone', 'device.name as namedevice')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['users.id' => Auth::user()->id])
            ->get();
        $home['history']=History::all();
        $home['user']=DB::table('users')->get();
        $home['room']=DB::table('room')->get();
        $home['device']=DB::table('device')->get();
        $home['zone']=DB::table('zone')->get();
        return view('user.page',['home' => $home]);
    }
    public function regisRoom(Request $request)
    {
        $history=new History;
        $history->id_zone=$request->zone;
        $history->id_user=Auth::user()->id;
        $history->id_room=$request->room;
        $history->id_device=implode(",",$request->device);
        $history->save();
        return redirect('/regisroom');
    }
    public function detailRoom($id)
    {
        return $history = History::find($id);
    }
    public function editRoom(Request $request)
    {
        $id=$request->id;
        History::where('id',$id)->update([
            'id_zone'=>$request->zone,
            'id_room'=>$request->room,
            'id_device'=>implode(",",$request->device)
        ]);
        return redirect('/regisroom');
    }
    public function deleteRoom($id){
        History::find($id)->delete();
    }
}
