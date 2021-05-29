<?php

namespace App\Http\Controllers;
use App\Models\Typedevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class typedeviceController extends Controller
{
    public function index(){
        $typedevice = db::table('typedevice')->get();
        return view('admin\typedevice\listtypedevice', ['typedevice' => $typedevice]);
    }
    public function addtypedevice(Request $request)
    {
        $typedevice=new Typedevice;
        $typedevice->name=$request->name;
        $typedevice->save();
        return redirect('admin/typedevice');

    }
    public function detailTypedevice($id)
    {
        return $typedevice = Typedevice::find($id);
    }
    public function edittypedevice(Request $request)
    {
        $id=$request->id;
        typedevice::where('id',$id)->update(['name'=>$request->name]);
        return redirect('admin/typedevice');
    }
    public function deleteTypedevice($id){
        Typedevice::find($id)->delete();
    }
}
