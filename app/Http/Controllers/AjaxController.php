<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Zone;

class AjaxController extends Controller
{
    public function getaddroom($id)
    {
        $addroom=Room::where('id_zone',$id)->where(['activity' => 0])->get();
        foreach($addroom as $add)
        {
            echo "<option  value='".$add->id."'>".$add->name."</option>";
        }
    }
    
    public function geteditroom($id)
    {
        $editroom=Room::where('id_zone',$id)->where(['activity' => 0])->get();
        foreach($editroom as $ed)
        {
            echo "<option  value='".$ed->id."'>".$ed->name."</option>";
        }
    }
    public function getaddhistory($id)
    {
        $room=Room::where('id_zone',$id)->where(['activity' => 0])->get();
        foreach($room as $rm)
        {
            echo "<option  value='".$rm->id."'>".$rm->name."</option>";
        }
    }
    public function getedithistory($id)
    {
        $room=Room::where('id_zone',$id)->where(['activity' => 0])->get();
        foreach($room as $rm)
        {
            echo "<option  value='".$rm->id."'>".$rm->name."</option>";
        }
    }
}
?>
