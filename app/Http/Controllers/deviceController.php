<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Typedevice;
use Illuminate\Support\Facades\DB;
use Validator;

class deviceController extends Controller
{
    public function index(){
        $typedevice=[];
        $typedevice['device'] = Device::select('device.*', 'typedevice.name as typename')
            ->join('typedevice','typedevice.id','=','device.id_type_device')->get();
        $typedevice['typedevice']=db::table('typedevice')->get();
        return view('admin\device\listdevice', ['typedevice' =>$typedevice]);
    }

    public function adddevice(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required'
        ],[
            'name.required'=>'Bạn chưa nhập tên thiết bị '
           
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $device=new device;
            $device->name=$request->name;
            $device->id_type_device=$request->typedevice;
            $device->save();
        // return redirect('admin/device');
           if( $device){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
                }
        }
       
    }
    public function detailDevice($id)
    {
        return $device = Device::find($id);
    }
    public function editDevice(Request $request)
    {
        $id=$request->id;
        Device::where('id',$id)->update([
            'name'=>$request->name,
            'id_type_device'=>$request->id_type_device,
            'activity'=>$request->activity,
            'status'=>$request->status
            ]);
        return redirect('admin/device');
    }
    public function deleteDevice($id){
        Device::find($id)->delete();
    }
}
