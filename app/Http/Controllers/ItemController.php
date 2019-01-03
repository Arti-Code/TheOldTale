<?php

namespace App\Http\Controllers;

use App\Item;
use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $character = Character::find(session('char_id'));
        $items = Item::where('character_id', $character->id)->get();
        if( !$items )   $items = null;
        return view('item.index')->with(['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $character = Character::find(session('char_id'));
        $item = Item::find($id);
        if( $item->character_id == $character->id || $item->location_id == $character->location_id )
        {
            if($item->character_id != null)
            {
                $charItem = $item;
                $locItem = Item::where('type', $charItem->type)->where('location_id', $character->location_id)->first();
                if( !$locItem )
                {
                    $locItem = new Item;
                    $locItem->id = null;
                    $locItem->type = $charItem->type;
                    $locItem->title = $charItem->type;
                    $locItem->amount = 0;
                    $locItem->character_id = null;
                    $locItem->location_id = $character->location_id;
                }
            }
            if($item->location_id != null)
            {
                $locItem = $item;
                $charItem = Item::where('type', $locItem->type)->where('character_id', $character->id)->first();
                if( !$charItem )
                {
                    $charItem = new Item;
                    $locItem->id = null;
                    $charItem->type = $locItem->type;
                    $charItem->title = $locItem->type;
                    $charItem->amount = 0;
                    $charItem->character_id = $character->id;
                    $charItem->location_id = null;
                }
            }
            return view('item.show')->with(['character' => $character, 'charItem' => $charItem, 'locItem' => $locItem]);
        }
        else
        {
            return redirect()->route('item.index')->with('danger', 'Nie znaleziono przedmiotu');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {

    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $checksum = 0;
        $character = Character::find(session('char_id'));
        $charItem = Item::find($request['char_item_id']);
        $locItem = Item::find($request['loc_item_id']);
        if( $request['char_item_val'] < 0 )     $request['char_item_val'] = 0;
        if( $request['loc_item_val'] < 0 )     $request['loc_item_val'] = 0;
        if( !$charItem )
        {
            $charItem = new Item;
            $charItem->type = $request['item_type'];
            $charItem->title = $request['item_type'];
            $charItem->character_id = $character->id;
            $charItem->location_id = null;
        }
        else    $checksum += $charItem->amount;

        if( !$locItem )
        {
            $locItem = new Item;
            $locItem->type = $request['item_type'];
            $locItem->title = $request['item_type'];
            $locItem->character_id = null;
            $locItem->location_id = $character->location_id;
        }
        else    $checksum += $locItem->amount;

        if( $charItem->character_id == $character->id && $locItem->location_id == $character->location_id )
        {
            if(($charItem->amount + $locItem->amount) <= $checksum)
            {
                $charItem->amount = $request['char_item_val'];
                $locItem->amount = $request['loc_item_val'];
                if( $charItem->amount > 0 )
                {
                    $charItem->save();
                }
                else
                {
                    $charItem->delete();
                }
                if( $locItem->amount > 0 )
                {
                    $locItem->save();
                }
                else
                {
                    $locItem->delete();
                }
                return redirect()->route('item.index')->with('success', 'Drop/Take udane');
            }
            else
            {
                return redirect()->route('item.index')->with('danger', 'Nieprawidłowe ilości przedmiotow');
            }
        }
        else
        {
            return redirect()->route('item.index')->with('danger', 'Nie znaleziono przedmiotu');
        }
    }

    public function location()
    {
        $character = Character::find(session('char_id'));
        $items = Item::where('location_id', $character->location_id)->get();
        if( !$items )   $items = null;
        return view('item.location')->with(['items' => $items]);
    }
}
