<?php

namespace App\Http\Controllers;

use App\Universum;
use App\Character;
use App\Progress;
use App\Route;
use App\Location;
use Illuminate\Http\Request;

class UniversumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('is_admin'))
        {
            $universums = Universum::all();
            return view('admin.universum.index')->with(["universums" => $universums]);
        }
    }

    public function nextturn($id)
    {
        if(session('is_admin'))
        {
            $universum = Universum::find($id);
            if($universum)
            {
                $i = 0;
                $log[$i] = "Universum: " . $universum->name . " end of turn: " . $universum->turn;
                $characters = Character::where('universum_id', $universum->id)->get();
                foreach($characters as $character)
                {
                    if($character->progress_id != null)
                    {
                        if($character->progress->type == 'travel')
                        {
                            $character->progress->act = $character->progress->act + 2;
                            if($character->progress->act < $character->progress->max)
                            {
                                $character->progress->save();
                                $i++;
                                $log[$i] = $character->name . " traveling to a new location...";
                            }
                            else
                            {
                                $route = Route::find($character->progress->target_id);
                                $character->progress->delete();
                                $character->location_id = $route->finish_id;
                                $character->progress_id = null;
                                $character->save();
                                $i++;
                                $log[$i] = $character->name . " reached to a new location...";
                            }
                        }
                    }
                }
                $universum->turn++;
                $universum->save();
                $i++;
                $log[$i] = "turn " . $universum->turn . " has begin.";
                return view('admin.universum.nextturn')->with(['log' => $log]);
            }
            else
            {
                return redirect()->route('home')->with('danger', 'selected universum do not exist');
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
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function show(Universum $universum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function edit(Universum $universum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universum $universum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Universum  $universum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Universum $universum)
    {
        //
    }
}
