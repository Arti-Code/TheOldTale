<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $guarded=[];

    const PRODUCTS = [ ['mace', 'bone knife', 'prim boots', 'sling', 'stone hammer', 'primitiv rod'] ];
    
    const TOOLS = [];
    

    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function util()
    {
        return $this->belongsTo('App\Util');
    }

    static function GET_FOOD($food_type)
    {
        $data = file_get_contents(public_path('json/food.json'));
        $food = json_decode($data, true);
        if(isset($food[$food_type]))
            return $food[$food_type];
        else
            return false;
    }

    static function GET_ALL_FOOD()
    {
        $data = file_get_contents(public_path('json/food.json'));
        $food = json_decode($data, true);
        if(isset($food))
            return $food;
        else
            return false;
    }

    static function GET_WEAPON($weapon_type)
    {
        $data = file_get_contents(public_path('json/weapons.json'));
        $weapons = json_decode($data, true);
        if(isset($weapons[$weapon_type]))
            return $weapons[$weapon_type];
        else
            return false;
    }

    static function GET_ALL_WEAPONS()
    {
        $data = file_get_contents(public_path('json/weapons.json'));
        $json = json_decode($data, true);
        if(isset($json))
            return $json;
        else
            return false;
    }

    static function GET_PRODUCT($type)
    {
        $data = file_get_contents(public_path('json/products.json'));
        $products = json_decode($data, true);
        if(isset($products[$type]))
            return $products[$type];
        else
            return false;
    }

    static function GET_RES($type)
    {
        $data = file_get_contents(public_path('json/resources.json'));
        $res = json_decode($data, true);
        if(isset($res[$type]))
            return $res[$type];
        else
            return false;
    }

    static function GET_ALL_RES()
    {
        $data = file_get_contents(public_path('json/resources.json'));
        $res = json_decode($data, true);
        if(isset($res))
            return $res;
        else
            return false;
    }

    static function GET_ALL_PRODUCTS()
    {
        $data = file_get_contents(public_path('json/products.json'));
        $prod = json_decode($data, true);
        if(isset($prod))
            return $prod;
        else
            return false;
    }
}
