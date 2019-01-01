<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
