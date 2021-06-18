<?php

namespace App\Http\Controllers;
use App\Models\History;
use App\Models\user;
use App\Models\Room;
use App\Models\Device;
use App\Models\Zone;
use App\Models\computer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class brokenController extends Controller
{
    public function index()
    {
        $room=[];
        $room['broken'] = Computer::select('computer.*', 'room.room_name as nameroom','zone.name as namezone')
            ->join('room','room.id','=','computer.id_room')
            ->join('zone','zone.id','=','room.id_zone')
            ->where(['computer.activity' => 0])
            ->get();
        $room['rooms']=db::table('room')->get();
        $room['zone']=db::table('zone')->get();
        $room['computer']=db::table('computer')->get();
        return view('admin/broken/listbroken',['room'=>$room]);
    }
    public function addBroken(Request $request){
        $id = $request->computer;
        Computer::where('id',$id)->update([
            'activity'=> 0,
            'description'=>$request->description,
        ]);
        return redirect('/admin/broken');
    }
    public function detailBroken($id){
        return $broken = Computer::find($id);
    }
    public function editBroken(Request $request){
        $id = $request->id;
        Computer::where('id',$id)->update([
            'activity'=> $request->activity,
            'description'=>$request->description,
        ]);
        return redirect('/admin/broken');
    }
}
