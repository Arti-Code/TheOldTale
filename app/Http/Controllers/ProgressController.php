<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Resource;
use App\Location;
use App\Character;
use App\Item;
use App\Message;
use App\LIB;
use App\Util;
use App\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProgressController extends Controller
{
   
    public function create($mode, $id)
    {
        $char = Character::find(session('char_id'));
        if( $mode == "collect" )
        {
            $res = Resource::find($id);
            if( ($res) && ($res->location_id == $char->location_id) )
            {
                if ($char->progress_id == null) 
                {
                    $items = Item::where('character_id', $char->id)->get();
                    $tools = [];
                    $res_spec = Item::GET_RES($res->type);
                    if (array_key_exists("none", $res_spec["tools"]))
                    {
                        $itm = new Item;
                        $itm->id = -1;
                        $itm->type = "none";
                        $itm->title = "none";
                        $itm->amount = 1;
                        $itm->character_id = $char->id;
                        array_push($tools, $itm);
                    }
                    foreach($items as $it)
                    {
                        if( array_key_exists($it->type, $res_spec["tools"]) )
                        {
                            array_push($tools, $it);
                        }
                    }
                    if( count($tools) > 0 )
                        return view('progress.create')->with(['mode' => 'collect', 'character' => $char, 'resource' => $res, 'tools' => $tools]);
                    else
                        return redirect()->route('location.show')->with('danger', 'Nie posiadasz właściwego narzędzia');
                } 
                else 
                {
                    return redirect()->route('location.show')->with('danger', 'Robisz już coś innego');
                }
            }
            else
            {
                return redirect()->route('location.show')->with('danger', 'Wybrano niewłaściwy zasoby');
            }
        }
    }

    public function store(Request $request)
    {
        $character = Character::find(session('char_id'));
        if ($character->progress_id == null) 
        {
            $r = Resource::find($request["res_id"]);
            if ($r->location_id == $character->location_id) 
            {
                $p = new Progress;
                $p->character_id = $character->id;
                $p->turns = 0;
                $p->total_turns = $r->turns;
                $p->cycles = 0;
                $p->total_cycles = $request["slider"];
                $p->type = 'collect';
                $p->resource_id = $r->id;
                $p->save();
                $p = Progress::where('character_id', $character->id)->first();
                $character->progress_id = $p->id;
                $character->save();
                MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' ' . $r->title);
                return redirect()->route('location.show')->with('success', 'Pozyskujesz surowce');
            }
        } 
        else 
        {
            if ($character->progress->type == "travel")
                return redirect()->route('navigation.travel')->with('danger', 'Robisz już coś innego');
            if ($character->progress->type == "collect")
                return redirect()->route('location.show')->with('danger', 'Robisz już coś innego');
            if ($character->progress->type == "craft")
                return redirect()->route('location.show')->with('danger', 'Robisz już coś innego');
        }
    }

    public function craft($name, $util_id)
    {
        $enough_res = true;
        $util = Util::find($util_id);
        $util_valid = false;
        $character = Character::find(session('char_id'));
        if( $character->progress_id == null )
        {
            $products = Item::GET_ALL_PRODUCTS();
            if( array_key_exists( $name, $products ) )
            {
                $item = Item::GET_PRODUCT($name);
                $item['name'] = $name;
                $inventory = []; 
                foreach( $item['res'] as $k => $val )
                {
                    //if( Item::REMOVE_ITEM($character->id, null, $k, $val) == false )
                    if( Item::ENOUGH_RES($character->id, null, $k, $val) == false )
                    {
                        $enough_res = false;
                    }    
                }
                unset($k);
                unset($val);
                if ($enough_res) 
                {
                    if( $util_id > 0 )
                    {
                        foreach( $item['util'] as $u )
                        {
                            if( $util->type == $u )
                                $util_valid = true;
                        }
                    }
                    else
                    {
                        if( array_key_exists("none", $item['util']) )
                            $util_valid = true;
                    }
                    if ( $util_valid )
                    {
                        foreach( $item['res'] as $k => $val )
                        {
                            Item::REMOVE_ITEM($character->id, null, $k, $val); 
                        }
                        if( $item['turn'] > 0 )
                        {
                            $p = new Progress;
                            $p->turns = 0;
                            $p->total_turns = $item['turn'];
                            $p->type = 'craft';
                            $p->product_type = $item['name'];
                            $p->character_id = $character->id;
                            $p->save();
                            $character->progress_id = $p->id;
                            $character->save();
                            MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' wytwarza ' . $p->product_type);
                            return redirect()->route('character.myself')->with('success', 'Rozpoczynasz wytwarzanie');
                        }
                        else
                        {
                            Item::ADD_ITEM($character->id, null, $item['name'], $item['return']);
                            MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' wytwarza ' . $item['name']);
                            return redirect()->back()->with('success', 'Zyskujesz ' . $item['name']); 
                        }
                    }
                    else
                    {
                        return redirect()->route('character.myself')->with('danger', 'Brak możliwości wykonania');
                    }
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

    public function destroy()
    {
        $char = Character::find(session('char_id'));
        $p = Progress::find($char->progress_id);
        if($p)
        {
            $p->delete();
            $char->progress_id = null;
            $char->save();
            return redirect()->back()->with('info', 'Przerwałeś dotychczasową czynnośc');
        }
        else
        {
            return redirect()->route('location.show')->with('danger', 'Ta czynnośc nie istnieje');
        }
    }

    public function construct($type)
    {
        $character = Character::find(session('char_id'));
        if ($character->progress_id == null) {
            if (array_key_exists($type, LIB::UTILITIES)) {
                $util = LIB::UTILITIES[$type];
                if ($util['turns'] > 0) {
                    $p = new Progress;
                    $p->character_id = $character->id;
                    $p->turns = 0;
                    $p->total_turns = $util['turns'];
                    $p->cycles = 0;
                    $p->total_cycles = 1;
                    $p->type = 'build';
                    $p->util = $type;
                    $p->save();
                    $p = Progress::where('character_id', $character->id)->first();
                    $character->progress_id = $p->id;
                    $character->save();
                    MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' tworzy ' . $type);
                    return redirect()->route('location.show')->with('success', 'Rozpocząłeś konstrukcję');
                } else {
                    UtilController::AddUtilToLoc($type, $character->location_id, $character->id);
                    MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' skonstruował ' . $type);
                    return redirect()->route('location.show')->with('success', 'Udało się');
                }
            } else {
                return redirect()->route('location.show')->with('danger', 'Wybrana konstrukcja nie istnieje');
            }
        } else {
            if ($character->progress->type == "travel")
                return redirect()->route('navigation.travel')->with('danger', 'Robisz już coś innego');
            if ($character->progress->type == "collect")
                return redirect()->route('location.show')->with('danger', 'Robisz już coś innego');
            if ($character->progress->type == "craft")
                return redirect()->route('location.show')->with('danger', 'Robisz już coś innego');
        }
    }

    static function GET_PROG($character)
    {
        $prog["bar"] = round( ( ( $character->progress->turns + $character->progress->cycles * $character->progress->total_turns ) 
            / ( $character->progress->total_cycles * $character->progress->total_turns ) ) * 100 );
        if($character->progress->type == 'collect')
        {
            $used_res = Resource::find($character->progress->resource_id);
            $prog["target"] = $used_res->type;
            $prog["type"] = 'collect';
        }
        if($character->progress->type == 'craft')
        {
            $prog["type"] = 'craft';
            $prog["target"] = $character->progress->product_type;
        }
        if ($character->progress->type == 'build') {
            $prog["target"] = $character->progress->util;
            $prog["type"] = 'build';
        }
        if ($character->progress->type == 'travel') {
            $route = Route::find($character->progress->route_id);
            $loc = Location::find($route->finish_id);
            $prog["target"] = $loc->name;
            $prog["type"] = 'build';
        }
        return $prog;
    }
}
