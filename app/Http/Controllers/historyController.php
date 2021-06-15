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

class historyController extends Controller
{
    public function index()
    {
        $history=[];
        $history['history'] = History::select('history.*', 'users.name as nameuser','zone.name as namezone','room.name as nameroom')
            ->join('users','users.id','=','history.id_user')
            ->join('zone','zone.id','=','history.id_zone')
            ->join('room','room.id','=','history.id_room')
            ->join('device','device.id','=','history.id_device')
            ->where(['users.id' => Auth::user()->id])
            ->get();
        $history['history'] = History::all();
        $history['user']=DB::table('users')->get();
        $history['room']=DB::table('room')->get();
        $history['zone']=DB::table('zone')->get();
        $history['device']=DB::table('device')->get();
        return view('admin/history/listhistory',['history'=>$history]);
    }
    public function addHistory(Request $request)
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
            $history->admin_check=$request->admincheck;
            $history->save();
            // return redirect('admin/history');
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
            'id_device'=>implode(",",$request->device)
        ]);
        return redirect('/admin/history');
    }
    public function deleteHistory($id){
        History::find($id)->delete();
    }
    public function Approval($id)
    {
        History::where('id',$id)->update([
            'admin_check'=> 1,
        ]);
        return redirect('/admin/history');
    }
    public function checkOut($id)
    {
        History::where('id',$id)->update([
            'admin_check'=> 1,
        ]);
        return redirect('/admin/history');
    }
}
