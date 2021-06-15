<?php

namespace App\Http\Controllers;
use App\Models\History;
use App\Models\user;
use App\Models\Room;
use App\Models\Device;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class historyController extends Controller
{
    public function index(Request $request)
    {
        $history=[];
        $history['history'] = History::select('history.*', 'users.name as nameuser','zone.name as namezone','room.name as nameroom')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['history.activity' => 0])->get();
        $history['user']=DB::table('users')->get();
        $history['room']=DB::table('room')->get();
        $history['zone']=DB::table('zone')->get();
        $history['device']=DB::table('device')->get();
        return view('admin/history/listhistory',['history'=>$history]);
    }
    public function addHistory(Request $request)
    {
        $history=new History;
        $history->id_zone=$request->zone;
        $history->id_user=Auth::user()->id;
        $history->id_room=$request->room;
        $history->id_device=implode(",",$request->device);
        $history->ms=$request->ms;
        $history->phone=$request->phone;
        $history->session=$request->sesion;
        $history->admin_check= 1;
        $history->save();
        Room::where('id',$request->room)->update([
            'activity'=> 1,
        ]);
        return redirect('admin/history');
    }
    public function detailHistory($id)
    {
        return $history = History::find($id);
    }
    public function editHistory(Request $request)
    {
        $id=$request->id;
        History::where('id',$id)->update([
            'id_zone'=>$request->zone,
            'ms'=>$request->ms,
            'phone'=>$request->phone,
            'admin_check'=>$request->admincheck,
            'session'=>$request->sesion,
            'id_room'=>$request->room,
            'id_device'=>implode(",",$request->device)
        ]);
        return redirect('/admin/history');
    }
    public function deleteHistory($id){
        $idroom = History::select('history.id_room')->where(['id' => $id])->get();
        Room::where('id',$request->room)->update([
            'activity'=> 0,
        ]);
        History::find($id)->delete();
    }
    public function Approval($id)
    {
        History::where('id',$id)->update([
            'admin_check'=> 1,
        ]);
        Room::where('id',$request->room)->update([
            'activity'=> 1,
        ]);
        return redirect('/admin/history');
    }
    public function detailCheckOut($id)
    {
        session()->push('idget',$id);
        return $historys = History::find($id);
    }
    public function submitCheckOut(Request $request)
    {
        $id=$request->id;
        $idroom=$request->id_room;
        History::where('id',$id)->update([
            'clean_up'=>$request->clean_up,
            'activity'=> 1 ,
        ]);
        Room::where('id',$idroom)->update([
            'activity'=> 0,
        ]);
        return redirect('/admin/history');
    }
    public function detailBroken($id){
        return $history = history::select('history.*', 'room.*','computer.*')
        ->join('room','room.id','=','history.id_room')
        ->join('computer','computer.id_room','=','room.id')
        ->where(['history.id'=>$id])->get();
    }
    public function submitBroken(){
        
    }
}
