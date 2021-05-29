<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typedevice extends Model
{
    use HasFactory;
    public $table ="typedevice";
    protected $primaryKey = 'id';
    public function divice()
    {
        return $this->hasMany('App\Models\Divice','id_type_device','id');
    }
    public function history()
    {
    return $this->hasManyThrough('App\Models\History','App\Models\Divice',
        'id_type_device','id_device','id');
    }
}
