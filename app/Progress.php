<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function route()
    {
        return $this->hasOne('App\Route');
    }    

    /*public function resource()
    {
        return $this->hasMany('App\Resource');
    }*/

    public function util()
    {
        return $this->hasOne('App\Util');
    }
}
