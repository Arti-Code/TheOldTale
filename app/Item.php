<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    const FOOD = ['fruit', 'fish', 'meat'];
    const FOOD_QUALITY = ['fruit' => 10, 'meat' => 20, 'fish' => 20];
    const PRODUCTS = [ ['mace', 'bone knife', 'prim boots', 'sling', 'stone hammer'] ];
    const PRODUCT =
    [
        'mace' =>
        [
            'turn' => 2,
            'res' => ['wood' => 3],
            'return' => 1
        ],
        'bone knife' =>
        [
            'turn' => 5,
            'res' => ['wood' => 1, 'bone' => 3, 'leather' => 1],
            'return' => 1
        ],
        'prim boots' =>
        [
            'turn' => 4,
            'res' => ['leather' => 5],
            'return' => 1
        ],
        'sling' =>
        [
            'turn' => 4,
            'res' => ['wood' => 2, 'leather' => 3],
            'return' => 1
        ],
        'stone hammer' =>
        [
            'turn' => 5,
            'res' => ['wood' => 4, 'stone' => 4],
            'return' => 1
        ],
    ];


    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
