<?php

namespace App\Http\Controllers;

use App\Character;
use App\Universum;
use App\Location;
use App\Name;
use App\Item;
use App\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = Character::where('user_id', Auth::id())->get();
        $char_count = $characters->count();
        if($char_count > 0)
            return view('character.index')->with(['characters' => $characters]);
        else
            return view('character.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universums = Universum::all();
        return view('character.create')->with(['universums' => $universums]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $character = new Character;
        $character->name = $request['name'];
        $character->sex = $request['sex'];
        $character->universum_id = $request['universum_id'];
        $character->user_id = Auth::id();
        $character->location_id = 1;
        $character->save();
        return redirect()->route('character.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Character $character)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $character = Character::find($id);
        if($character->user_id == Auth::id())
        {
            $character->delete();
        }
        return redirect()->back();
    }

    public function select($id)
    {
        $character = Character::find($id);
        if($character->user_id == Auth::id())
        {
            session(['char_id' => $character->id]);
            session(['char_name' => $character->name]);
        }
        return redirect()->route('character.myself');
    }

    public function myself()
    {
        $character = Character::find(session('char_id'));
        if($character->user_id == Auth::id())
        {
            if($character->progress_id == null)
            {
                $loc = Location::find($character->location_id);
                $name = Name::where('location_id', $loc->id)->where('owner_id', $character->id)->first();
                if($name)
                    $location = $name->title;
                else
                    $location = "land with no name";
                $progress = null;
            }
            else
            {
                if($character->progress->type == 'travel')
                {
                    $location = "traveling...";
                }
                if($character->progress->type == 'collect')
                {
                    $location = "collecting resources...";
                }
                if($character->progress->type == 'craft')
                {
                    $location = "crafting things...";

                }
                $p = Progress::find($character->progress_id);
                $progress['type'] = $p->type;
                $progress['value'] = round( ($p->act / $p->max) * 100);
            }

            return view('character.myself')->with(["character" => $character, "location" => $location, "progress" => $progress]);
        }
    }

    public function eat($id)
    {
        $character = Character::find(session('char_id'));
        $item = Item::find($id);
        if($item->character_id == $character->id)
        {
            $food = $character->satiety + Item::FOOD_QUALITY[$item->type];
            if( $character->satiety < 91 && $item->amount > 0 )
            {
                $character->satiety = $food;
                if( $character->satiety > 100 )   $character->satiety = 100;
                $item->amount--;
                $character->save();
                if( $item->amount > 0 )     $item->save();
                else    $item->delete();
                return redirect()->route('item.index')->with('success', 'Posiliłeś się');
            }
        }
        else
        {
            return redirect()->route('item.index')->with('danger', 'Nie znaleziono przedmiotu');
        }
    }

    public function craft()
    {
        $character = Character::find(session('char_id'));
        $products_list = Item::PRODUCTS[0];
        $products = [];
        foreach($products_list as $pl)
        {
            $products[$pl] = Item::PRODUCT[$pl];
        }
        return view('character.craft')->with(["character" => $character, "products" => $products]);
    }

    /*public function craftThis($name)
    {
        $character = Character::find(session('char_id'));
        $products = Item::PRODUCT;
        if( array_key_exists( $name, $products ) )
        {
            $item = Item::PRODUCT[$name];
            $item['name'] = $name;
            $inventory = [];
            foreach( $item['res'] as $k => $val )
            {
                $i = Item::where('character_id', $character->id)->where('type', $k)->first();
                if( $i )
                {
                    if( $i->amount > $val )     $i->amount = $val;
                    array_push($inventory, $i);
                }
                else
                {
                    $i = new Item;
                    $i->type = $k;
                    $i->title = $k;
                    $i->amount = $val;
                    $i->character_id = $character->id;
                }
            }
            return view('character.craftthis')->with(["character" => $character, "inventory" => $inventory, "item" => $item]);
        }
        else
        {
            return redirect()->back()->with('danger', 'Wybrano niewłaściwy przedmiot');
        }
    }*/
}
