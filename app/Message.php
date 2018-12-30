<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function character()
    {
        return $this->belongsTo('App\Character');
    }
}
