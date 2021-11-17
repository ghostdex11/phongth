<?php

namespace App\Http\Controllers;
use App\Models\Typedevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
class typedeviceController extends Controller
{
    public function index(){
        $typedevice = db::table('typedevice')->get();
        return view('admin\typedevice\listtypedevice', ['typedevice' => $typedevice]);
    }
    public function addtypedevice(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required'
        ],[
            'name.required'=>'Bạn chưa nhập tên loại thiết bị '
           
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $typedevice=new Typedevice;
            $typedevice->name=$request->name;
            $typedevice->save();
            // return redirect('admin/typedevice');
           if( $typedevice){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
                }
        }
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
