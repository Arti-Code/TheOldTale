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

}
