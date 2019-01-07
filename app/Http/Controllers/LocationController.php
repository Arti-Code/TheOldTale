<?php

namespace App\Http\Controllers;

use App\Location;
use App\Character;
use App\Universum;
use App\Name;
use App\Resource;
use App\Progress;
use Illuminate\Http\Request;

class LocationController extends Controller
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
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $character = Character::find(session('char_id'));
        if( ($character->progress_id == null) || ($character->progress->type == 'collect') || ($character->progress->type == 'craft') )
        {
            $location = Location::find($character->location_id);
            $name = Name::where('location_id', $location->id)->where('owner_id', $character->id)->first();
            if($name)
                $priv_name = $name->title;
            else
                $priv_name = "unknown";
            $people = Character::where('location_id', $location->id)->where('id', '<>', $character->id)->get();
            $progress = null;
            $res = null;
            if($character->progress_id == null)
            {
                $res = Resource::where('location_id', $location->id)->get();
                $progress = new Progress;
            }
            else
            {
                if($character->progress->type == 'collect')
                {
                    $progress = $character->progress;
                    $res = Resource::find($progress->target_id);
                }
                if($character->progress->type == 'craft')
                {
                    $progress = $character->progress;
                    $res = Resource::where('location_id', $location->id)->get();
                }
            }

            return view('location.show')->with(["location" => $location, "title" => $priv_name, 'people' => $people, 'res' => $res, 'prog' => $progress]);
        }
        elseif($character->progress->type == 'travel')
        {
            return redirect()->route('navigation.travel');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
