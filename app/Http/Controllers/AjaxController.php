<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Zone;
use App\Models\Computer;
class AjaxController extends Controller
{
    public function getaddroom($id)
    {
        $addroom=Room::where('id_zone',$id)->where(['status' => 0])->get();
        foreach($addroom as $add)
        {
            echo "<option  value='".$add->id."'>".$add->room_name."</option>";
        }
    }
    
    public function geteditroom($id)
    {
        $editroom=Room::where('id_zone',$id)->where(['status' => 0])->get();
        foreach($editroom as $ed)
        {
            echo "<option  value='".$ed->id."'>".$ed->room_name."</option>";
        }
    }
    public function getaddhistory($id)
    {
        $room=Room::where('id_zone',$id)->where(['status' => 0])->get();
        foreach($room as $rm)
        {
            echo "<option  value='".$rm->id."'>".$rm->room_name."</option>";
        }
    }
    public function getedithistory($id)
    {
        $room=Room::where('id_zone',$id)->where(['status' => 0])->get();
        foreach($room as $rm)
        {
            echo "<option  value='".$rm->id."'>".$rm->room_name."</option>";
        }
    }
    public function getaddbroken($id)
    {
        $room=Room::where('id_zone',$id)->get();
        echo "<option  value='0'>--Chọn phòng--</option>";
        foreach($room as $rm)
        {
            echo "<option  value='".$rm->id."'>".$rm->room_name."</option>";
        }
    }
    public function getaddcomputer($id)
    {
        $computer=Computer::where('id_room',$id)->where(['activity' => 1])->get();
        echo "<option  value='0'>--Chọn computer--</option>";
        foreach($computer as $rm)
        {
            echo "<option  value='".$rm->id."'>".$rm->computer_name."</option>";
        }
    }
}
?>
