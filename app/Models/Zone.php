<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    // use HasFactory;
    public $table = "zone";
    protected $primaryKey = 'id';
    public static function getNameZone($id) {
        $zone = Zone::findOrFail($id)->name;
        return $zone ? $zone : "";
    }
}
