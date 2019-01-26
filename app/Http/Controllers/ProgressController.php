<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Resource;
use App\Location;
use App\Character;
use App\Item;
use App\Message;
use App\LIB;
//use ItemController;
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
                    if (array_key_exists("none", LIB::TOOLS_FOR_RES($res->type)))
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
                        if( array_key_exists($it->type, LIB::TOOLS_FOR_RES($res->type)) )
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
                $p->target_id = $r->id;
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
                /*foreach( $item['res'] as $k => $val )
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
                }*/
                
                foreach( $item['res'] as $k => $val )
                {
                    /*$i = Item::where('character_id', $character->id)->where('type', $k)->first();
                    $i->amount = $i->amount - $val;
                    if( $i->amount > 0 )    $i->save();
                    else $i->delete();*/
                    if( !ItemController::RemoveItemFromChar($character->id, $k, $val) )
                        $enough_res = false;
                }
                if ($enough_res) 
                {
                    $p = new Progress;
                    $p->turns = 0;
                    $p->total_turns = $item['turn'];
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
