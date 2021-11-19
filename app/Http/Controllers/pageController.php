<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

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
        $home['history'] = History::select('history.*', 'users.name as nameuser' , 'room.room_name as nameroom', 'zone.name as namezone', 'device.name as namedevice')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['users.id'=> Auth::user()->id])
            ->where(['history.check_out' => 0])
            ->get();
            $home['zone'] = db::table('zone')->get();
            $home['room'] = db::table('room')->get();
            $home['device'] = db::table('device')->get();
        return view('user/page',['home' => $home]);
    }
    public function regisRoom(Request $request)
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
            if($d =='true'){
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
                $history->save();
                return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
            }
        }
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
            'id_device'=>implode(",",$request->device),
            'ms'=>$request->ms,
            'phone'=>$request->phone,
            'session'=>$request->sesion,
            'date_time'=>$request->date_time,
        ]);
        return redirect('/regisroom');
    }
    public function deleteRoom($id){
        History::find($id)->delete();
    }
}
