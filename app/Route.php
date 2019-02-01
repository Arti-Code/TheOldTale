<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function progress()
    {
        return $this->belongsTo('App\Progress');
    }

}
