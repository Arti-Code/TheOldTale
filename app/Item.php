<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    const FOOD = ['fruit', 'fish', 'meat'];
    const FOOD_QUALITY = ['fruit' => 10, 'meat' => 20, 'fish' => 20];


    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
