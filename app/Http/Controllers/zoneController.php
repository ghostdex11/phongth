<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Validator;
class zoneController extends Controller
{
    public function index(){
        $zone = db::table('zone')->get();        
        return view('admin\zone\listzone', ['zone' => $zone]);
    }
    public function addZone(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'location'=>'required'
        ],[
            'name.required'=>'Bạn chưa nhập tên khu ',
            'location.required'=>'Bạn chưa nhập vị trí'
           
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $zone = new Zone;
            $zone -> name = $request -> name;
            $zone -> location = $request -> location;
            $zone -> save();
        // return redirect('admin/zone');
           if( $zone){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
                }
        }
        
    }
    public function deleteZone($id){
        Zone::find($id)->delete();
    }
    public function detailZone($id){
        return $zone = Zone::find($id);
    }
    public function editZone(Request $request){
        $id = $request -> id;
        Zone::where('id', $id)->update([
            'name' => $request -> name,
            'location' => $request -> location,
        ]);
        return redirect('admin/zone');
    }   
}
