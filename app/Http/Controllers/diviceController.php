<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divice;
use App\Models\Typedevice;
use Illuminate\Support\Facades\DB;

class diviceController extends Controller
{
    public function index(){
        $typedevice=[];
        $typedevice['device'] = db::table('device')->get();
        $typedevice['typedevice']=db::table('typedevice')->get();
        return view('admin\device\listdevice', ['device' =>$typedevice,'typedevice' =>$typedevice]);
    }

    public function adddevice(Request $request)
    {
        $device=new divice;
        $device->name=$request->name;
        $device->id_type_device=$request->typedevice;
        $device->save();
        return redirect('admin/device');

    }
}
