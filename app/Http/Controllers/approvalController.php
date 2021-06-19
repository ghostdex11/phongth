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
use Validator;

class approvalController extends Controller
{
    public function index(Request $request)
    {
        $history=[];
        $history['history'] = History::select('history.*', 'users.name as nameuser','zone.name as namezone','room.room_name as nameroom')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['history.check_out' => 0])
            // ->where(['users.id' => Auth::user()->id])
            ->get();
        // $history['history'] = History::all();
        $history['user']=DB::table('users')->get();
        $history['room']=DB::table('room')->get();
        $history['zone']=DB::table('zone')->get();
        $history['device']=DB::table('device')->get();
        $history['computer']=DB::table('computer')->get();
        return view('admin/approval/approval',['history'=>$history]);
    }
    public function addHistory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ms'=>'required',
            'phone'=>'required',
            'zone'=>'required',
            'room'=>'required',
            'device'=>'required', 
            'date_time'=>'required'
        ],[
            'ms.required'=>'Bạn chưa nhập mã số',
            'phone.required'=>'Bạn chưa nhập số điện thoại',
            'zone.required'=>'Bạn chưa chọn khu',
            'room.required'=>'Bạn chưa chọn phòng',
            'device.required'=>'Bạn chưa chọn thiết bị',
            'date_time.required'=>'Bạn chưa chọn ngày'
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{        
            $history=new History;
            $history->id_zone=$request->zone;
            $history->id_user=Auth::user()->id;
            $history->id_room=$request->room;
            $history->id_device=implode(",",$request->device);
            $history->ms=$request->ms;
            $history->phone=$request->phone;
            $history->session=$request->sesion;
            $history->date_time=$request->date_time;
            $history->admin_check= 1;
            $history->save();
            Room::where('id',$request->room)->update([
                'status'=> 1,
            ]);
            if( $history){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
            }
        }
       
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
            'date_time'=>$request->date_time,
            'id_device'=>implode(",",$request->device)
        ]);
        return redirect('/admin/approval');
    }
    public function deleteHistory($id){
        $idroom = DB::table('history')->where('id', $id)->first();
        Room::where('room.id' , $idroom -> id_room)->update([   
            'room.status' => 0,
        ]);
        History::find($id)->delete();
    }
    public function Approval($id)
    {
        History::where('id',$id)->update([
            'admin_check'=> 1,
        ]);
        $idroom = DB::table('history')->where('id', $id)->first();
        Room::where('id', $idroom -> id_room)->update([
            'room.status'=> 1,
        ]);
        return redirect('/admin/approval');
    }
    public function detailCheckOut($id)
    {
        return $historys = History::select('history.*', 'room.*') 
        ->join('room','room.id','=','history.id_room')
        ->where(['history.id'=>$id])->first();
    }
    public function submitCheckOut(Request $request)
    {
        $id=$request->id;
        $idroom=$request->id_room;
        History::where('id',$id)->update([
            'clean_up'=>$request->clean_up,
            'check_out'=> 1
        ]);
        Room::where('id',$idroom)->update([
            'status'=> 0
        ]);
        return redirect('/admin/approval');
    }
}
