<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Util extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
