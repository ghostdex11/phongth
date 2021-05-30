<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typedevice extends Model
{
    // use HasFactory;
    public $table ="typedevice";
    protected $primaryKey = 'id';
    
    public function device()
    {
        return $this->hasMany('App\Models\Device','id_type_device','id');
    }
}
