<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    // use HasFactory;
    public $table = "device";
    protected $primaryKey = 'id';
    public function history()
    {
       return $this->hasMany('App\Models\History','id_device','id');
    }
    public function typedevice()
    {
        return $this->belongsTo('App\Models\Typedevice','id_type_device','id');
    }

    public static function getDeviceUser($id) {
        $device = Device::findOrFail($id)->name;
        return $device ? $device : "";
    }
}
