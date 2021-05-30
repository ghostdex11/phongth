<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
class computerController extends Controller
{
    public function index(){
        $computer=[];
        $computer['computer'] = Computer::select('computer.*', 'room.name as roomname')
            ->join('room','room.id','=','computer.id_room')->get();
        $computer['room']=db::table('room')->get();
        return view('admin\computer\listcomputer', ['computer' =>$computer]);
    }

    public function addComputer(Request $request)
    {
        $computer=new Computer;
        $computer->name=$request->name;
        $computer->id_room=$request->id_room;
        $computer->save();
        return redirect('admin/computer');
    }
    public function detailComputer($id)
    {
        return $conputer = Computer::find($id);
    }
    public function editComputer(Request $request)
    {
        $id=$request->id;
        Computer::where('id',$id)->update([
            'name'=>$request->name,
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
