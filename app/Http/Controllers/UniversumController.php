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
        $universums = Universum::all();
        return view('admin.universum.index')->with(["universums" => $universums]);
    }

    public function nextturn($id)
    {
        if( $this->CalcUniv($id) )
        {
            return redirect()->route('admin.universum.index')->with('success', 'NOWA TURA');
        }
        else
        {
            return redirect()->route('home')->with('danger', 'Wybrane universum nie istnieje');
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

    public function CalcUniv($univ_id)
    {
        $universum = Universum::find($univ_id);
        if($universum)
        {
            $msg = new Message;
            $characters = Character::where('universum_id', $universum->id)->get();
            foreach($characters as $character)
            {
                $this->calcHunger($character);
                $this->calcHealth($character);
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
                    elseif($character->progress->type == 'craft')
                    {
                        $this->calcCraft($character);
                    }
                }
                $character->fight = true;
                $this->calcDeath($character);
                $character->save();
            }
            $universum->turn++;
            $universum->save();
            MessageController::ADD_GLOBAL_MSG($universum->id, 'NASTAJE NOWA TURA');
            return true;
        }
        else
        {
            return false;
        }
    }

    private function calcTravel(Character $character)
    {
        $character->progress->act = $character->progress->act + 1;
        if($character->progress->act < $character->progress->max)
        {
            $character->progress->save();
        }
        else
        {
            $route = Route::find($character->progress->target_id);
            $character->progress->delete();
            $character->location_id = $route->finish_id;
            $character->progress_id = null;
            $time = date("Y-m-d H:i:s");
            $character->arrival_time = $time;
            MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' przybywa');
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
            $random_val = rand(0, 100);
            if( $random_val <= $result->luck  )
            {
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
                }
            }
        }
    }

    private function calcCraft(Character $character)
    {
        $character->progress->act = $character->progress->act + 1;
        if($character->progress->act < $character->progress->max)
        {
            $character->progress->save();
        }
        else
        {
            $item = Item::where('character_id', $character->id)->where('type', $character->progress->target)->first();
            if( $item )
            {
                $item->amount = $item->amount + 1;
            }
            else
            {
                $item = new Item;
                $item->type = $character->progress->target;
                $item->title = $character->progress->target;
                $item->amount = 1;
                $item->character_id = $character->id;
            }
            $item->save();
            $character->progress->delete();
            $character->progress_id = null;
            $character->save();
        }
    }

    public function calcHunger(Character $character)
    {
        $character->satiety = $character->satiety - Character::HUNGER_MOD;
        if($character->satiety < 0)     $character->satiety = 0;
    }

    public function calcHealth(Character $character)
    {
        if($character->health > 0)
        {
            $h = round( ( $character->health - 50 ) / 10 );
            $s = round( ( $character->satiety - 50 ) / 5 );
            if( $s < 0 )    $s = $s * 2;
            if( $character->health < 70 )   $v = rand(0, $h);
            else $v = 0;
            $character->health = $character->health + $h + $s - $v;
            if($character->health > 100)    $character->health = 100;
            elseif($character->health < 0)  $character->health = 0;
        }
        else
        {
            $character->health = 0;
        }
    }

    public function calcDeath(Character $character)
    {
        if( $character->health <= 0 )
        {
            MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' umiera...');
            $character->dead = true;
            $character->location_id = -1;
        }
    }
}
