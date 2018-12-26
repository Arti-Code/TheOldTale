<?php

namespace App\Http\Controllers;

use App\Route;
use App\Character;
use App\Location;
use App\Name;
use App\Progress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check())
            return redirect()->route('home')->with('danger', 'Authentication error. You must login.');
        if(!session('char_id'))
            return redirect()->route('character.index')->with('warning', 'Character is not selected.');
        $progress = Progress::where('character_id', session('char_id'))->first();
        $character = Character::find(session('char_id'));
        if($character->progress_id == null)
        {

            $location = Location::find($character->location_id);
            $results = Route::where('location_id', $location->id)->get();
            $start_name = Name::where('location_id', $location->id)->where('owner_id', $character->id)->first();
            if(!$start_name)
            {
                $start_name = new Name;
                $start_name->title = "land with no name";
            }
            $i = 0;
            foreach ($results as $result)
            {
                $routes[$i]['id'] = $result->id;
                $routes[$i]['start_id'] = $result->location_id;
                $routes[$i]['finish_id'] = $result->finish_id;
                $finish_name = Name::where('owner_id', $character->id)->where('location_id', $result->finish_id)->first();
                if(!$finish_name)
                {
                    $finish_name = new Name;
                    $finish_name->title = "land with no name";
                }
                $finish_loc = Location::where('id', $result->finish_id)->first();
                $routes[$i]['finish'] = $finish_name->title;
                $routes[$i]['type'] = $finish_loc->type;
                $routes[$i]['distance'] = $result->distance;
                $i++;
            }
            if($start_name != null)
                return view('navigation.index')->with(['routes' => $routes, 'location_name' => $start_name->title]);
            else
                return view('navigation.index')->with(['routes' => $routes, 'location_name' => 'untitled']);
        }
        else
        {
            if($progress->type == 'travel')
            {
                return redirect()->route('navigation.travel');
            }
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
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        //
    }

    public function select($id)
    {
        if(!Auth::check())
            return redirect()->route('home')->with('danger', 'Authentication error. You must login.');
        if(!session('char_id'))
            return redirect()->route('character.index')->with('warning', 'Character is not selected.');
        $character = Character::find(session('char_id'));
        $location = Location::find($character->location_id);
        $route = Route::find($id);
        if(!$route)
            return redirect()->back()->with('danger', 'Selected route do not exist.');
        if($route->location_id != $location->id)
            return redirect()->back()->with('danger', 'Selected route is not proper for this location.');
        $progress = new Progress;
        $progress->character_id = $character->id;
        $progress->act = 0;
        $progress->max = $route->distance;
        $progress->type = 'travel';
        $progress->target_id = $route->id;
        $progress->save();
        $character->progress_id = $progress->id;
        $character->save();
        return redirect()->route('navigation.travel');
    }

    public function travel()
    {
        if(!Auth::check())
            return redirect()->route('home')->with('danger', 'Authentication error. You must login.');
        if(!session('char_id'))
            return redirect()->route('character.index')->with('warning', 'Character is not selected.');
        $character = Character::find(session('char_id'));
        $progress = Progress::find($character->progress_id);
        $route = Route::find($progress->target_id);
        $start_name = Name::where('location_id', $route->location_id)->where('owner_id', $character->id)->first();
        $finish_name = Name::where('location_id', $route->finish_id)->where('owner_id', $character->id)->first();
        if(!$start_name)
        {
            $start_name = new Name;
            $start_name->title = 'land with no name';
            $start_name->location_id = $route->location_id;
        }
        if(!$finish_name)
        {
            $finish_name = new Name;
            $finish_name->title = 'land with no name';
            $finish_name->location_id = $route->finish_id;
        }
        $percent = round(($progress->act / $progress->max) * 100);
        $travel = ['start_id' => $start_name->location_id, 'start_name' => $start_name->title, 'finish_id' => $finish_name->location_id, 'finish_name' => $finish_name->title, 'progress' => $percent];
        return view('navigation.travel')->with($travel);
    }

}
