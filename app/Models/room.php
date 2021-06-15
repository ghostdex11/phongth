<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public $table="room";
    protected $primaryKey = 'id';
    public static function getNameRoom($id) {
        $room = Room::findOrFail($id)->room_name;
        return $room ? $room : "";
    }
}
