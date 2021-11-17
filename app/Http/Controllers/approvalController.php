<?php

namespace App\Http\Controllers;
use App\Models\History;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class approvalController extends Controller
{
    public function index()
    {
        $history=[];
        $history['history'] = History::select('history.*', 'users.name as nameuser','zone.name as namezone','room.room_name as nameroom')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['history.check_out' => 0])
            ->get();
        return view('admin/approval/approval',['history'=>$history]);
    }
    public function addApproval(Request $request)
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
        }
        else
        {   
            $history=new History;
            $a = DB::table('history')->select(['id_room','date_time','session'])->where(['check_out' => 0])->get();
            for($i=0;$i<count($a);$i++){
                $d='false'; 
                $m = $a[$i];
                if($m->id_room == $request->room && $m->date_time == $request->date_time && $m->session == $request->sesion){
                   $d='true';
                }
            }
            if($d == 'true'){
                return response()->json(['status'=>2, 'msg'=>'Phòng đã có người đặt']);
            }
            else{
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
                return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
            }
        }
    }
    public function detailApproval($id)
    {
        return $history = History::find($id);
    }
    public function editApproval(Request $request)
    {
        $id=$request->id;
        History::where('id',$id)->update([
            'id_device'=>"",
        ]);
        // History::where('id',$id)->delete('id_device');
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
    public function deleteApproval($id){
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
        return redirect('/admin/approval');
    }
    public function detailCheckOut($id)
    {
        return $historys = History::select('history.*', 'room.room_name') 
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
