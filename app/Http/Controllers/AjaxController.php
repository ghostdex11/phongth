<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Zone;

class AjaxController extends Controller
{
    public function getroom($id)
    {
        $floor=Room::where('id_zone',$id)->get();
        foreach($floor as $fl)
        {
            echo "<option  value='".$fl->id."'>".$fl->name."</option>";
        }
    }
    public function getfloor($id)
    {
        $room=Room::where('id',$id)->get();
        foreach($room as $ro)
        {
            echo "<option  value='".$ro->id."'>".$ro->floor."</option>";
        }
    }
}
?>
