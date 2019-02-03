<?php

namespace App\Http\Controllers;

use App\Universum;
use App\Character;
use App\Progress;
use App\Route;
use App\Location;
use App\Message;
use App\Item;
use App\Util;
use App\Resource;
use App\Http\Controllers\ItemController;
//use App\Http\Controllers\UtilController;
use Illuminate\Http\Request;

class UniversumController extends Controller
{

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

    public function destroy($id)
    {
        $univ = Universum::find($id);
        if( $univ )
        {
            $chars = Character::where('universum_id', $id)->get();
            if( $chars )
            {
                foreach ($chars as $char) 
                {
                    Item::where('character_id', $char->id)->delete();
                    Message::where('character_id', $char->id)->orWhere('receiver_id', $char->id)->delete();
                    Progress::where('character_id', $char->id)->delete();
                }
                Character::where('universum_id', $id)->delete();
            }    
            $locs = Location::where('universum_id', $id)->get();
            if( $locs )
            {
                foreach ($locs as $loc) 
                {
                    Message::where('location_id', $loc->id)->orWhere('universum_id', $id)->delete();
                    Resource::where('location_id', $loc->id)->delete();
                    Route::where('location_id', $loc->id)->delete();
                }
                Location::where('universum_id', $id)->delete();
            }
            $univ->delete();
            return redirect()->route('admin.universum.index')->with('info', 'Wskazane universum zostało usunięte');
        }
        else
        {
            return redirect()->route('admin.universum.index')->with('danger', 'Wybrane universum nie istnieje');
        }
    }

    public function CalcUniv($univ_id)
    {
        $universum = Universum::find($univ_id);
        if($universum)
        {
            $characters = Character::where('universum_id', $universum->id)->get();
            foreach($characters as $character)
            {
                $this->calcHunger($character);
                $this->calcHealth($character);
                if($character->progress_id != null)
                {
                    //$character->rest = $character->rest - 10;
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
                    elseif($character->progress->type == 'build')
                    {
                        $this->calcBuild($character);
                    }
                }
                else
                {
                    $character->rest = $character->rest + 5;
                    MessageController::ADD_SYS_PRIV_MSG($character->location_id, $character->id, "Odpoczywasz i odzyskujesz siły");
                }
                $character->fight = true;
                $this->calcDeath($character);
                if($character->rest > 100)
                    $character->rest = 100;
                elseif ($character->rest < 0)
                    $character->rest = 0;
                if($character->happy > 100)
                    $character->happy = 100;
                elseif ($character->happy < 0)
                    $character->happy = 0;
                $character->save();
            }
            $locations = Location::where('universum_id', $univ_id)->get();
            foreach($locations as $location)
            {
                $utils = Util::where('location_id', $location->id)->get();
                if( $utils )
                {
                    foreach ($utils as $util) 
                    {
                        if( $util->lifetime > 0 )
                        {
                            $util->lifetime = $util->lifetime - 1;
                        }
                        if($util->lifetime > 0)   $util->save();
                        if($util->lifetime == 0)   $util->delete();
                    }
                }
            }
            $universum->turn++;
            $universum->save();
            return true;
        }
        else
        {
            return false;
        }
    }

    private function calcTravel(Character $character)
    {
        $character->progress->turns = $character->progress->turns + 1;
        $character->rest = $character->rest - 20;
        if($character->progress->turns < $character->progress->total_turns)
        {
            $character->progress->save();
        }
        else
        {
            $route = Route::find($character->progress->route_id);
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
        $character->progress->turns = $character->progress->turns + 1;
        if($character->progress->turns < $character->progress->total_turns)
        {
            $character->progress->save();
        }
        else
        {
            $result = Resource::find($character->progress->resource_id);
            $character->progress->cycles = $character->progress->cycles + 1;
            if($character->progress->cycles == $character->progress->total_cycles )
            {
                $character->progress->delete();
                $character->progress_id = null;
                $character->save();
            } 
            else
            {
                $character->progress->turns = 0;
                $character->progress->save();
            }
            $random_val = rand(0, 100);
            if( $random_val <= $result->luck  )
            {
                $res = json_decode($result->components, true);
                foreach($res as $key => $r)
                {
                    ItemController::AddItem($character->id, null, $key, $r);
                    MessageController::ADD_SYS_PRIV_MSG($character->location_id, $character->id, "Zdobywasz trochę " . $key . ".");
                }
            }
        }
    }

    private function calcCraft(Character $character)
    {
        $character->progress->turns = $character->progress->turns + 1;
        if($character->progress->turns < $character->progress->total_turns)
        {
            $character->progress->save();
        }
        else
        {
            ItemController::AddItemToChar($character->id, $character->progress->product_type, 1);
            $character->progress->delete();
            $character->progress_id = null;
            $character->save();
        }
    }

    private function calcBuild(Character $character)
    {
        $character->progress->turns = $character->progress->turns + 1;
        if($character->progress->turns < $character->progress->total_turns)
        {
            $character->progress->save();
        }
        else
        {
            UtilController::AddUtilToLoc($character->progress->util, $character->location_id, $character->id);
            MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . " skonstruował " . $character->progress->util);
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
            $body = new Item;
            $body->type = "zwłoki " . $character->name;
            $body->title = $body->type;
            $body->amount = 1;
            $body->location_id = $character->location_id;
            $body->save();
            MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' umiera...');
            $items = Item::where('character_id', $character->id)->get();
            foreach($items as $item)
            {
                ItemController::AddItemToLoc($character->location_id, $item->type, $item->amount);
                $item->delete();
            }
            $character->dead = true;
            $character->location_id = -1;
        }
    }

    public function calcUtils()
    {

    }
}
