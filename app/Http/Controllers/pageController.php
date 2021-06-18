<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;
use App\Models\Room;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\RedirectResponse;

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
            ->where(['users.id' => Auth::user()->id])
            ->get();
        // $home['history']=History::all();
        $home['user']=DB::table('users')->get();
        $home['room']=DB::table('room')->get();
        $home['device']=DB::table('device')->get();
        $home['zone']=DB::table('zone')->get();
        return view('user/page',['home' => $home]);
    }
    public function regisRoom(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ms'=>'required',
            'phone'=>'required',
            'zone'=>'required',
            'room'=>'required',
            'device'=>'required'
        ],[
            'ms.required'=>'Bạn chưa nhập mã số',
            'phone.required'=>'Bạn chưa nhập số điện thoại',
            'zone.required'=>'Bạn chưa chọn khu',
            'room.required'=>'Bạn chưa chọn phòng',
            'device.required'=>'Bạn chưa chọn thiết bị'
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
            $history->save();
            // return redirect('/regisroom');
           if( $history){
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
            'session'=>$request->sesion
        ]);
        return redirect('/regisroom');
    }
    public function deleteRoom($id){
        History::find($id)->delete();
    }
}
