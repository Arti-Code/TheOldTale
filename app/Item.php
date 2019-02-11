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

    static function GET_EQUIPMENT($type)
    {
        $data = file_get_contents(public_path('json/equipment.json'));
        $json = json_decode($data, true);
        if(isset($json[$type]))
            return $json[$type];
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

    static function IS_SINGLE()
    {
        $data = file_get_contents(public_path('json/single.json'));
        $json = json_decode($data, true);
        if(isset($json))
            return true;
        else
            return false;
    }

    static function ENOUGH_RES($char_id, $loc_id, $res_type, $needed_amount)
    {
        $amount = 0;
        $res = self::where('character_id', $char_id)->where('location_id', $loc_id)->where('type', $res_type)->where('wearable', null)->first();
        if( $res )
        {
            if($res->amount >= $needed_amount)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    static function ADD_ITEM($char_id, $loc_id, $item_type, $quantity)
    {
        $jsonItem = self::GET_PRODUCT($item_type);
        if( empty($jsonItem) || !$jsonItem["single"] )
        {
            if( $char_id != null )
                $item = Item::where('character_id', $char_id)->where('type', $item_type)->first();
            if( $loc_id != null )
                $item = Item::where('location_id', $loc_id)->where('type', $item_type)->first();
            if ($item) 
            {
                $item->amount = $item->amount + $quantity;
            } 
            else 
            {
                $item = new Item;
                $item->type = $item_type;
                $item->title = $item_type;
                $item->amount = $quantity;
                $item->character_id = $char_id;
                $item->location_id = $loc_id;
            }
            $item->save();
        }
        else
        {
            
            for ($i=0; $i < $quantity; $i++) 
            {
                $item = new Item;
                $item->type = $item_type;
                $item->title = $item_type;
                $item->amount = 1;
                $item->character_id = $char_id;
                $item->location_id = $loc_id;
                $item->save();
            }
        }
    }

    static function REMOVE_ITEM($char_id, $loc_id, $item_type, $quantity)
    {
        $jsonItem = self::GET_PRODUCT($item_type);
        if( empty($jsonItem) || !$jsonItem["single"] )
        {
            if( $char_id != null )
                $item = self::where('character_id', $char_id)->where('type', $item_type)->first();
            if( $loc_id != null )
                $item = self::where('location_id', $loc_id)->where('type', $item_type)->first();
            if ($item) 
            { 
                if ( $item->amount > $quantity )
                {
                    $item->amount = $item->amount - $quantity;
                    $item->save();
                    return true;
                }
                elseif ($item->amount == $quantity)
                {
                    $item->delete();
                    return true;
                }     
                else 
                {      
                    return false;
                }
            }
        }
        else
        {
            if( $char_id != null )
                $items = self::where('character_id', $char_id)->where('type', $item_type)->get();
            if( $loc_id != null )
                $items = self::where('location_id', $loc_id)->where('type', $item_type)->get();
            if ($items && count($items) >= $quantity)
            {
                $index = 0;
                foreach ($items as $i ) 
                {
                    $i->delete();
                    $index++;
                    if($index >= $quantity)
                        break;
                }
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
