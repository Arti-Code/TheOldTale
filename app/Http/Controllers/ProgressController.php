<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Location;
use App\Character;
use App\Item;
use App\Message;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function show(Progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress $progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Progress $progress)
    {
        //
    }

    public function craft($name)
    {
        $enough_res = true;
        $character = Character::find(session('char_id'));
        if( $character->progress_id == null )
        {
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
                        if( $i->amount < $val )     $enough_res = false;
                    }
                    else
                    {
                        $enough_res = false;
                    }
                }
                if( $enough_res )
                {
                    foreach( $item['res'] as $k => $val )
                    {
                        $i = Item::where('character_id', $character->id)->where('type', $k)->first();
                        $i->amount = $i->amount - $val;
                        if( $i->amount > 0 )    $i->save();
                        else $i->delete();
                    }
                    $p = new Progress;
                    $p->act = 0;
                    $p->max = $item['turn'];
                    $p->type = 'craft';
                    $p->target = $item['name'];
                    $p->character_id = $character->id;
                    $p->save();
                    $character->progress_id = $p->id;
                    $character->save();
                    MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' wytwarza ' . $p->target);
                    return redirect()->route('character.myself')->with('success', 'Rozpoczynasz wytwarzanie');
                }
                else
                {
                    return redirect()->route('character.myself')->with('danger', 'Potrzebujesz więcej surowcow');
                }
            }
            else
            {
                return redirect()->back()->with('danger', 'Wybrano niewłaściwy przedmiot');
            }
        }
        else
        {
            return redirect()->route('character.myself')->with('danger', 'Robisz już coś innego');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $char = Character::find(session('char_id'));
        $p = Progress::find($id);
        if($p)
        {
            if($char->id == $p->character_id)
            {
                $p->delete();
                $char->progress_id = null;
                $char->save();
                return redirect()->route('location.show')->with('info', 'Przerwałeś dotychczasową czynnośc');
            }
            else
            {
                return redirect()->route('location.show')->with('danger', 'Niewłaściwa czynnośc');
            }
        }
        else
        {
            return redirect()->route('location.show')->with('danger', 'Ta czynnośc nie istnieje');
        }
    }
}
