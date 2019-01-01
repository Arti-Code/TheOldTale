<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Location;
use App\Character;
use Illuminate\Http\Request;

class ProgressController extends Controller
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
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function show(Progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress $progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Progress $progress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
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
                return redirect()->route('location.show')->with('info', 'You have cancelled your works...');
            }
            else
            {
                return redirect()->route('location.show')->with('danger', 'Specified progress isn\'t your own');
            }
        }
        else
        {
            return redirect()->route('location.show')->with('danger', 'Specified progress doesn\'t exist');
        }
    }
}
