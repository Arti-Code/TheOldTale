<?php

namespace App\Http\Controllers;

use App\Resource;
use App\Character;
use App\Progress;
use App\Message;
use Illuminate\Http\Request;

class ResourceController extends Controller
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
        $character = Character::find(session('char_id'));
        if ($character->progress_id == null) {
            $r = Resource::find($id);
            if ($r->location_id == $character->location_id) {
                $p = new Progress;
                $p->character_id = $character->id;
                $p->act = 0;
                $p->max = 1;
                $p->type = 'collect';
                $p->target_id = $r->id;
                $p->save();
                $p = Progress::where('character_id', $character->id)->first();
                $character->progress_id = $p->id;
                $character->save();
                MessageController::ADD_SYS_PUB_MSG($character->location_id, $character->name . ' ' . $r->title);
                return redirect()->route('location.show')->with('success', 'Pozyskujesz surowce');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        //
    }

    public function select($id)
    {
        $character = Character::find(session('char_id'));
        $r = Resource::find($id);
        if( $character->location_id == $r->location_id )
        {
            if ($character->progress_id == null) 
            {
                return view('resource.select')->with(['character' => $character, 'resource' => $r]);
            }
            else
            {
                return redirect()->route('location.show')->with('danger', 'Robisz już coś innego');
            }
        }
        else
        {
            return redirect()->route('location.show')->with('danger', 'Niewlaściwe zasoby');
        }
    }
}
