<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LIB extends Model
{
    const UTILITIES = 
    [
        'campfire' => ['inside' => [ 'location', 'cottage' ], 'tool' => [], 'building' => ['wood' => 3], 'turns' => 0, 'keeping' => ['wood' => 1], 'storage' => 10, 'places' => 0, 'lifetime' => 6 ],
        'cottage' => ['inside' => ['location'], 'tool' => ['stone hammer' => 30], 'building' => ['wood' => 10], 'turns' => 3, 'keeping' => [], 'storage' => 30, 'places' => 2, 'lifetime' => -1 ],
        'primitiv hut' => ['inside' => ['location'], 'tool' => ['stone hammer' => 30], 'building' => ['wood' => 7], 'turns' => 3, 'keeping' => [], 'storage' => 30, 'places' => 2, 'lifetime' => -1 ]
    ];

    static function TOOLS_FOR_RES($res_type)
    {
        return self::RESOURCES[$res_type];
    }
}
