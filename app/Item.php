<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    const FOOD = ['fruit', 'fish', 'meat', 'apple'];
    const FOOD_QUALITY = ['fruit' => 5, 'meat' => 20, 'fish' => 15, 'apple' => 5];
    const WEAPON = ['mace' => [ 'dmg' => 20, 'adv' =>20 ], 'bone knife' => [ 'dmg' => 35, 'adv' =>10 ], 'sling' => [ 'dmg' => 20, 'adv' => 0 ], 'stone hammer' => [ 'dmg' => 20, 'adv' => 15 ], 'stone axe' => ['dmg' => 20, 'adv' => 15] ];
    const PRODUCTS = [ ['mace', 'bone knife', 'prim boots', 'sling', 'stone hammer', 'primitiv rod'] ];
    const PRODUCT =
    [
        'mace' =>
        [
            'turn' => 6,
            'res' => ['wood' => 9],
            'tool' => null,
            'return' => 1
        ],
        'bone knife' =>
        [
            'turn' => 20,
            'res' => ['wood' => 3, 'bone' => 9, 'leather' => 3],
            'tool' => null,
            'return' => 1
        ],
        'prim boots' =>
        [
            'turn' => 12,
            'res' => ['leather' => 15],
            'tool' => 'bone knife',
            'return' => 1
        ],
        'sling' =>
        [
            'turn' => 8,
            'res' => ['wood' => 6, 'leather' => 9],
            'tool' => null,
            'return' => 1
        ],
        'stone hammer' =>
        [
            'turn' => 20,
            'res' => ['wood' => 12, 'stone' => 12],
            'tool' => null,
            'return' => 1
        ],
        'primitiv rod' =>
            [
            'turn' => 20,
            'res' => ['wood' => 12, 'bone' => 2],
            'tool' => null,
            'return' => 1
        ]
    ];
    const TOOLS = [];
    

    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
