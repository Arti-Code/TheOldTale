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
            $name = Name::where('location_id', $location->id)->where('owner_id', $character->id)->first();
            if($name)
                $priv_name = $name->title;
            else
                $priv_name = $location->name;
            $people = Character::where('location_id', $location->id)->where('id', '<>', $character->id)->get();
            $progress = null;
            $res = null;
            $utils = null;
            $target = null;
            $progress_bar = null;
            $utils = Util::where('location_id', $location->id)->get();
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
                    $res = Resource::where('location_id', $location->id)->get();
                    $used_res = Resource::find($progress->target_id);
                    $target = $used_res->type;
                    $progress_bar = round( ( ( $progress->turns + $progress->cycles * $progress->total_turns ) / ( $progress->total_cycles * $progress->total_turns ) ) * 100 );
                }
                if($character->progress->type == 'craft')
                {
                    $progress = $character->progress;
                    $target = $progress->target;
                    $res = Resource::where('location_id', $location->id)->get();
                    $progress_bar = round( ( ( $progress->turns + $progress->cycles * $progress->total_turns ) / ( $progress->total_cycles * $progress->total_turns ) ) * 100 );
                }
                if ($character->progress->type == 'build') {
                    $progress = $character->progress;
                    $target = $progress->util;
                    $res = Resource::where('location_id', $location->id)->get();
                    $progress_bar = round( ( ( $progress->turns + $progress->cycles * $progress->total_turns ) / ( $progress->total_cycles * $progress->total_turns ) ) * 100 );
                }
            }

            return view('location.show')->with(["location" => $location, "title" => $priv_name, 'people' => $people, 'res' => $res, 'utils' => $utils, 'prog' => $progress, 'progress_bar' => $progress_bar, 'target' => $target]);
        }
        elseif($character->progress->type == 'travel')
        {
            return redirect()->route('navigation.travel');
        }
    }

    
    public function destroy(Location $location)
    {
        //
    }

    public function place()
    {
        return view('location.place');
    }
}
