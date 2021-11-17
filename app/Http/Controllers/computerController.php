<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;
use Illuminate\Support\Facades\DB;
use Validator;
class computerController extends Controller
{
    public function index(){
        $computer=[];
        $computer['computer'] = Computer::select('computer.*', 'room.room_name as roomname')
            ->join('room','room.id','=','computer.id_room')->get();
        $computer['room']=db::table('room')->get();
        return view('admin\computer\listcomputer', ['computer' =>$computer]);
    }

    public function addComputer(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required'
        ],[
            'name.required'=>'Bạn chưa nhập tên máy',
           
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $computer=new Computer;
            $computer->computer_name=$request->name;
            $computer->id_room=$request->id_room;
            $computer->save();
        // return redirect('admin/computer');
           if( $computer){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
                }
        }
       
    }
    public function detailComputer($id)
    {
        return $conputer = Computer::find($id);
    }
    public function editComputer(Request $request)
    {
        $id=$request->id;
        Computer::where('id',$id)->update([
            'computer_name'=>$request->name,
            'id_room'=>$request->id_room,
            'mouse'=>$request->mouse,
            'keyboard'=>$request->keyboard,
            'activity'=>$request->activity,
            'description'=>$request->description,
            ]);
        return redirect('admin/computer');
    }
    public function deleteComputer($id){
        Computer::find($id)->delete();
    }
}
