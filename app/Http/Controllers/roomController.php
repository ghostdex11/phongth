<?php

namespace App\Http\Controllers;
use App\Models\Zone;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

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
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'floor'=>'required'
        ],[
            'name.required'=>'Bạn chưa nhập tên phòng ',
            'floor.required'=>'Bạn chưa nhập tầng'
           
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $room=new room;
            $room->room_name=$request->name;
            $room->id_zone=$request->zone;
            $room->floor=$request->floor;
            $room->description=$request->description;
            $room->save();
            // return redirect('admin/room');
           if( $room){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
                }
        }
        
    }
    public function detailRoom($id)
    {
        return $room = room::find($id);
    }
    public function editRoom(Request $request)
    {
        $id=$request->id;
        Room::where('id',$id)->update([
            'room_name'=>$request->name,
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
