<?php

namespace App\Http\Controllers;

use App\Universum;
use App\Character;
use App\Progress;
use App\Route;
use App\Location;
use App\Message;
use App\Item;
use App\Resource;
use Illuminate\Http\Request;

class UniversumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('is_admin'))
        {
            $universums = Universum::all();
            return view('admin.universum.index')->with(["universums" => $universums]);
        }
    }

    public function nextturn($id)
    {
        if(session('is_admin'))
        {
            $universum = Universum::find($id);
            if($universum)
            {
                //$i = 0;
                $msg = new Message;
                //$log[$i] = "Universum: " . $universum->name . " end of turn: " . $universum->turn;
                $characters = Character::where('universum_id', $universum->id)->get();
                foreach($characters as $character)
                {
                    $this->calcHunger($character);
                    if($character->progress_id != null)
                    {
                        if($character->progress->type == 'travel')
                        {
                            $this->calcTravel($character);
                        }
                        elseif($character->progress->type == 'collect')
                        {
                            $this->calcCollect($character);
                        }
                    }

                }
                $universum->turn++;
                $universum->save();
                //$i++;
                $log = "turn " . $universum->turn . " has begin.";

                return view('admin.universum.nextturn')->with(['log' => $log]);
            }
            else
            {
                return redirect()->route('home')->with('danger', 'selected universum do not exist');
            }
        }
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
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function show(Universum $universum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function edit(Universum $universum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universum $universum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Universum $universum)
    {
        //
    }

    private function calcTravel(Character $character)
    {
        $character->progress->act = $character->progress->act + 2;
        if($character->progress->act < $character->progress->max)
        {
            $character->progress->save();
            //$i++;
            //$log[$i] = $character->name . " traveling to a new location...";
        }
        else
        {
            $route = Route::find($character->progress->target_id);
            $character->progress->delete();
            $character->location_id = $route->finish_id;
            $character->progress_id = null;
            $character->save();
            //$i++;
            //$log[$i] = $character->name . " reached to a new location...";
            $msg = new Message;
            $msg->location_id = $character->location_id;
            $msg->type = 'SYS_PUB';
            $msg->text = $character->name . ' przybywa tutaj';
            $msg->save();
        }
    }

    private function calcCollect(Character $character)
    {
        $character->progress->act = $character->progress->act + 1;
        if($character->progress->act < $character->progress->max)
        {
            $character->progress->save();
        }
        else
        {
            $result = Resource::find($character->progress->target_id);
            $character->progress->delete();
            $character->progress_id = null;
            $character->save();
            if($result->components == null)
            {
                $res = [$result->type => $result->amount];
            }
            else
            {
                $res = json_decode($result->components, true);
            }
            foreach($res as $key => $r)
            {
                $item = Item::where('character_id', $character->id)->where('type', $key)->first();
                if( $item )
                {
                    $item->amount = $item->amount + $r;
                }
                else
                {
                    $item = new Item;
                    $item->type = $key;
                    $item->title = $key;
                    $item->amount = $r;
                    $item->character_id = $character->id;
                }
                $item->save();
                /*$msg = new Message;
                $msg->location_id = $character->location_id;
                $msg->type = 'SYS_PUB';
                $msg->text = $character->name . ' zdobywa ' . $key;
                $msg->save();*/
            }
        }
    }

    public function calcHunger(Character $character)
    {
        $character->satiety = $character->satiety - Character::HUNGER_MOD;
        if($character->satiety < 0)     $character->satiety = 0;
        $character->save();
    }
}
