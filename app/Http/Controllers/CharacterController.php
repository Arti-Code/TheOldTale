<?php

namespace App\Http\Controllers;

use App\Character;
use App\Universum;
use App\Location;
use App\Name;
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
        $character->universum_id = $request['universum_id'];
        $character->user_id = Auth::id();
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
        if(session('char_id') != null)
        {
            $character = Character::find(session('char_id'));
            if($character->user_id == Auth::id())
            {
                $loc = Location::find($character->location_id);
                $name = Name::where('location_id', $loc->id)->where('owner_id', $character->id)->first();
                if($name)
                    $location = ["id" => $loc->id, "type" => $loc->type, "title" => $name->title];
                else
                    $location = ["id" => $loc->id, "type" => $loc->type, "title" => 'unknown'];
                return view('character.myself')->with(["character" => $character, "location" => $location]);
            }
        }
    }
}
