<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
class zoneController extends Controller
{
    public function index(){
        $zone = db::table('zone')->get();        
        return view('admin\zone\listzone', ['zone' => $zone]);
    }
    public function addZone(Request $request){
        $zone = new Zone;
        $zone -> name = $request -> name;
        $zone -> location = $request -> location;
        $zone -> save();
        return redirect('admin/zone');
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
