<?php

namespace App\Http\Controllers;

use App\Character;
use App\Universum;
use App\Location;
use App\Name;
use App\Item;
use App\Progress;
use App\Message;
use App\Http\Controllers\UniversumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{

    public function index()
    {
        $characters = Character::where('user_id', Auth::id())->get();
        $char_count = $characters->count();
        if($char_count > 0)
            return view('character.index')->with(['characters' => $characters]);
        else
            return view('character.index');
    }

    public function create()
    {
        $universums = Universum::all();
        return view('character.create')->with(['universums' => $universums]);
    }

    public function store(Request $request)
    {
        $unique_char = Character::where('name', $request['name'])->where('universum_id', $request['universum_id'])->first();
        if( !$unique_char )
        {
            $one_char = Character::where('user_id', Auth::id())->where('universum_id', $request['universum_id'])->first();
            if( !$one_char || session('is_admin'))
            {
                $character = new Character;
                $character->name = $request['name'];
                $character->sex = $request['sex'];
                if( $character->sex == "M")
                {
                    $i = rand(1, 6);
                    $character->avatar = "m" . $i;
                }
                else
                {
                    $i = rand(1, 6);
                    $character->avatar = "f" . $i;
                }
                $character->universum_id = $request['universum_id'];
                $character->user_id = Auth::id();
                $character->location_id = 9;
                $time = date("Y-m-d H:i:s");
                $character->arrival_time = $time;
                $character->save();
                return redirect()->route('character.index')->with('success', 'Utworzyłeś nową postac');
            }
            else
            {
                return redirect()->back()->with('danger', 'Możesz posiadac tylko jedna postac w danym Universum');
            }

        }
        else
        {
            return redirect()->back()->with('danger', 'Postac o tej nazwie już istnieje');
        }
    }

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
        if( $character->weapon_id != null )
            $weapon = Item::find($character->weapon_id);
        else
        {
            $weapon = new Item;
            $weapon->type = 'fists';
        }
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
            if($character->progress->type == 'build')
            {
                $location = "building something...";

            }
            $p = Progress::find($character->progress_id);
            $progress['type'] = $p->type;
            $progress['value'] = round((($p->turns + $p->cycles * $p->total_turns) / ($p->total_cycles * $p->total_turns)) * 100);
        }
        return view('character.myself')->with(["character" => $character, "location" => $location, "progress" => $progress, "weapon" => $weapon]);
    }

    public function eat($id)
    {
        $character = Character::find(session('char_id'));
        $item = Item::find($id);
        if($item->character_id == $character->id)
        {
            $food = $character->satiety + Item::FOOD[$item->type];
            if( $character->satiety < 100 && $item->amount > 0 )
            {
                $character->satiety = $food;
                if( $character->satiety > 100 )   $character->satiety = 100;
                $item->amount--;
                $character->save();
                if( $item->amount > 0 )     $item->save();
                else    $item->delete();
                return redirect()->route('item.index')->with('success', 'Posiliłeś się');
                
            }
            else
            {
                return redirect()->route('item.index')->with('warning', 'Jesteś najedzony. Nie zjesz już nic więcej');
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

    public function fight()
    {
        $character = Character::find(session('char_id'));
        $other = Character::where('location_id', $character->location_id)->where('id', '<>', $character->id)->get();
        $weapon = Item::find($character->weapon_id);
        if( !$weapon)
        {
            $weapon = new Item;
            $weapon->type = 'fists';
        }
        return view ( 'character.fight' )->with(["character" => $character, "weapon" => $weapon, "other" => $other]);
    }

    public function weaponEquip($id)
    {
        $character = Character::find(session('char_id'));
        $weapon = Item::find($id);
        if($weapon->character_id == $character->id)
        {
            $character->weapon_id = $weapon->id;
            $character->save();
            return redirect()->back()->with('success', 'Wybrano broń');
        }
        else
        {
            return redirect()->back()->with('danger', 'Nieprawidłowa broń');
        }
    }

    public function other($id)
    {
        $character = Character::find(session('char_id'));
        $other = Character::find($id);
        $weapon = Item::find($other->weapon_id);
        if( $character->location_id == $other->location_id)
        {
            return view('character.other')->with( [ 'other' => $other, 'weapon' => $weapon] );
        }
        else
        {
            return redirect()->back()->with('danger', 'Nieprawidłowa osoba');
        }
    }

    public function attack($id)
    {
        $character = Character::find(session('char_id'));
        $enemy = Character::find($id);
        if($enemy->location_id == $character->location_id)
        {
            if( $character->fight = 1 )
            {
                $character->fight = 0;
                $msg = new Message;
                $msg2 = new Message;
                if($character->weapon_id != null)
                {
                    $item = Item::find($character->weapon_id);
                    $weapon = Item::WEAPON[$item->type];
                    $weapon['name'] = $item->type;
                }
                else
                {
                    $weapon['name'] = 'fists';
                    $weapon['dmg'] = 0;
                    $weapon['adv'] = 0;
                }
                if($enemy->weapon_id != null)
                {
                    $item = Item::find($enemy->weapon_id);
                    $weaponE = Item::WEAPON[$item->type];
                    $weaponE['name'] = $item->type;
                }
                else
                {
                    $weaponE['name'] = 'fists';
                    $weaponE['dmg'] = 0;
                    $weaponE['adv'] = 0;
                }
                $hm = 50 + $weapon['adv'];
                $he = 50 + $weaponE['adv'];
                $ww = round ( ( $hm + ( 100 - $he ) ) / 2 );
                $rand = rand(0, 100);
                if( $ww >= $rand )
                {
                    $str = rand(0, 20) + $weapon['dmg'];
                    $enemy->health = $enemy->health - $str;
                    $enemy->save();
                    $text1 = $character->name . ' hit ' . $enemy->name . ' using ' . $weapon['name'];
                    if( $enemy->health <= 0 )
                    {
                        $univCtrl = new UniversumController;
                        $univCtrl->calcDeath($enemy);
                    }
                }
                else
                {
                    $text1 = $character->name . ' miss ' . $enemy->name . ' using ' . $weapon['name'];
                }
                MessageController::ADD_FIGHT_MSG($character->location_id, $text1);

                $ww2 = round ( ( $he + ( 100 - $hm ) ) / 2 );
                $rand2 = rand(0, 100);
                if( $ww2 >= $rand2 )
                {
                    $str2 = rand(0, 20) + $weaponE['dmg'];
                    $character->health = $character->health - $str2;
                    $character->save();
                    $text2 = $enemy->name . ' hit ' . $character->name . ' using ' . $weaponE['name'];
                    if( $character->health <= 0 )
                    {
                        $univCtrl = new UniversumController;
                        $univCtrl->calcDeath($character);
                    }
                }
                else
                {
                    $text2 = $enemy->name . ' miss ' . $character->name . ' using ' . $weaponE['name'];
                }
                MessageController::ADD_FIGHT_MSG($enemy->location_id, $text2);
                return redirect()->route('message.index');
            }
            else
            {
                return redirect()->back()->with('danger', 'Atakowac możesz raz na turę');
            }
        }
    }

    public function remove($id)
    {
        $char = Character::find($id);
        if( $char )
        {
            if( $char->user_id == Auth::id() )
            {
                $char->user_id = null;
                $char->save();
                return redirect()->route('character.index')->with('info', 'Postać została usunięta...');
            }
            else
            {
                return redirect()->route('character.index')->with('danger', 'Postać nie należy do Ciebie...');
            }
        }
        else
        {
            return redirect()->route('character.index')->with('danger', 'Postać nie istnieje...');
        }
    }
}
