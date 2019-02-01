<?php

namespace App\Http\Controllers;

use App\Util;
use App\Item;
use App\Character;
use App\Progress;
use App\LIB;
use Illuminate\Http\Request;

class UtilController extends Controller
{
   
    public function index()
    {

    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(Util $util)
    {
        //
    }

  
    public function edit(Util $util)
    {
        //
    }

 
    public function update(Request $request, Util $util)
    {
        //
    }

 
    public function destroy(Util $util)
    {
        //
    }

    public function list($id)
    {
        $character = Character::find(session('char_id'));
        $utilities = LIB::UTILITIES;
        $utils = [];
        foreach ($utilities as $key => $value) 
        {
            if (in_array('location', $value['inside'])) 
            {
                $utils[$key] = $value;
            }

        }
        return view('util.location.list')->with(["character" => $character, "utils" => $utils]);
    }

    public function campfire($id)
    {
        $character = Character::find(session('char_id'));
        $util = Util::find($id);
        if( $util )
        {
            if( $character->location_id == $util->location_id )
            {
                $character = Character::find(session('char_id'));
                $products_list = Item::PRODUCT;
                $products = [];
                foreach($products_list as $key => $value)
                {
                    if( in_array('campfire', $value['util']) )
                    $products[$key] = $value;
                }
                $store = $this->GetItemsList($util->id);
                return view('util.campfire.index')->with(["character" => $character, "products" => $products, "util" => $util, "store" => $store]);
            }
            else
            {
                return redirect()->route('location.show')->with('danger', 'Niewłaściwy wybór');
            }
        }
        else
        {
            return redirect()->route('location.show')->with('danger', 'Niewłaściwy wybór');
        }
    }

    

    static function AddUtilToLoc($type, $loc_id, $char_id)
    {
        if( array_key_exists($type, LIB::UTILITIES) )
        {
            $util = LIB::UTILITIES[$type];
            $u = new Util;
            $u->type = $type;
            $u->title = $type;
            $u->location_id = $loc_id;
            $u->character_id = $char_id;
            $u->lifetime = $util['lifetime'];
            $u->save();
            return true;
        }
        else
        {
            return false;
        }
    }
 
    private function GetItemsList($util_id)
    {
        $items = Item::where('util_id', $util_id)->get();
        return $items;
    }
}
