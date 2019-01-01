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
        $deer = Config::get('item.deer.meat');
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
        if( $item->character_id == $character->id )
        {
            $other = Character::where('location_id', $character->location_id)->where('id', '<>', $character->id)->get();
            if( !$other ) $other = null;
            return view('item.show')->with(['character' => $character, 'other' => $other, 'item' => $item]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
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

    public function dropoff(Request $request)
    {
        $character = Character::find(session('char_id'));
        $item = Item::find($request['item_id']);
        if( $item )
        {
            if( $item->amount >= $request['amount'] )
            {
                $item->amount = $item->amount - $request['amount'];
                if( $request['amount'] > 0 )
                {
                    $item_dropped = new Item;
                    $item_dropped->type = $item->type;
                    $item_dropped->title = $item->type;
                    $item_dropped->amount = $request['amount'];
                    $item_dropped->character_id = null;
                    $item_dropped->location_id = $character->location_id;
                    $item_dropped->save();
                }
                if( $item->amount > 0 )
                    $item->save();
                else
                    $item->delete();
                return redirect()->route('item.index')->with('success', 'Wyrzuciłeś przedmioty');
            }
        }
        else
        {
            return redirect()->route('item.index')->with('danger', 'Nie znaleziono przedmiotu');
        }
    }
}
