<?php

namespace App\Http\Controllers;

use App\Location;
use App\Character;
use App\Universum;
use App\Name;
use App\Resource;
use App\Progress;
use App\LIB;
use App\Util;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    
    public function show(Location $location)
    {
        $character = Character::find(session('char_id'));
        if( ($character->progress_id == null) || ($character->progress->type == 'collect') || ($character->progress->type == 'craft') || ($character->progress->type == 'build') )
        {
            $location = Location::find($character->location_id);
            $people = Character::where('location_id', $location->id)->where('id', '<>', $character->id)->get();
            $res = null;
            $utils = null;
            $prog = null;
            $utils = Util::where('location_id', $location->id)->get();
            if($character->progress_id == null)
            {
                $res = Resource::where('location_id', $location->id)->get();
            }
            else
            {
                $prog = ProgressController::GET_PROG($character);
                $res = Resource::where('location_id', $location->id)->get();
                
            }

            return view('location.show')->with(["location" => $location, 'character' => $character, 'people' => $people, 'res' => $res, 'utils' => $utils, 'prog' => $prog]);
        }
        elseif($character->progress->type == 'travel')
        {
            return redirect()->route('navigation.travel');
        }
    }

    public function place()
    {
        return view('location.place');
    }
}
