<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universum extends Model
{
    protected $guarded=[];

    public function character()
    {
        return $this->hasMany('App\Character');
    }

    public function location()
    {
        return $this->hasMany('App\Location');
    }
}
