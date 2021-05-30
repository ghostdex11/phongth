<?php

namespace App\Http\Controllers;
use App\Models\Zone;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class roomController extends Controller
{
    public function index()
    {
        $room=[];
        $room['room'] = room::select('room.*', 'zone.name as namezone')
            ->join('zone','zone.id','=','room.id_zone')->get();
        $room['zone']=db::table('zone')->get();
        return view('admin/room/listroom',['room'=>$room]);
    }
    public function addroom(Request $request)
    {
        $room=new room;
        $room->name=$request->name;
        $room->id_zone=$request->zone;
        $room->floor=$request->floor;
        $room->description=$request->description;
        $room->save();
        return redirect('admin/room');
    }
    public function detailRoom($id)
    {
        return $room = room::find($id);
    }
    public function editRoom(Request $request)
    {
        $id=$request->id;
        Room::where('id',$id)->update([
            'name'=>$request->name,
            'id_zone'=>$request->id_zone,
            'floor'=>$request->floor,
            'clean_up'=>$request->clean_up,
            'activity'=>$request->activity,
            'status'=>$request->status,
            'description'=>$request->description
        ]);
        return redirect('admin/room');
    }
    public function deleteRoom($id){
        room::find($id)->delete();
    }
}
