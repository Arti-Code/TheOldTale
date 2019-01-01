<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    public function universum()
    {
        return $this->belongsTo('App\Universum');
    }

    public function character()
    {
        return $this->hasMany('App\Character');
    }

    public function name()
    {
        return $this->hasMany('App\Name');
    }

    public function route()
    {
        return $this->hasMany('App\Route');
    }

    public function message()
    {
        return $this->hasMany('App\Message');
    }

    public function item()
    {
        return $this->hasMany('App\Item');
    }
}
