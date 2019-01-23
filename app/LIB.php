<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LIB extends Model
{
    const RESOURCES =
    [
        'wood' => ['none' => 0, 'stone axe' => 25],
        'stone' => ['none' => 0, 'stone pick' => 25],
        'fish' => [' none ' => 0, 'primitiv rod' => 30]
    ];

    static function TOOLS_FOR_RES($res_type)
    {
        return self::RESOURCES[$res_type];
    }
}
