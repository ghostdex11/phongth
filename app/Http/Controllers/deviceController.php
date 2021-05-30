<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Typedevice;
use Illuminate\Support\Facades\DB;

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
        $device=new device;
        $device->name=$request->name;
        $device->id_type_device=$request->typedevice;
        $device->save();
        return redirect('admin/device');
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
