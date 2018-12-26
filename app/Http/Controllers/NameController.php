<?php

namespace App\Http\Controllers;

use App\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NameController extends Controller
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
        $name = Name::where('location_id', $request['location_id'])->where('owner_id', session('char_id'))->first();
        if($name)
        {
            $name->title = $request['title'];
        }
        else
        {
            $name = new Name;
            $name->title = $request['title'];
            $name->location_id = $request['location_id'];
            $name->owner_id = session('char_id');
        }
        $name->save();
        return redirect()->route('character.myself');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function show(Name $name)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Name::where('location_id', $id)->where('owner_id', session('char_id'))->first();
        if($result)
        {
            $name = ['location_id' => $result->location_id, 'title' => $result->title];
        }
        else
        {
            $name = ['location_id' => $id, 'title' => null];
        }
        return view('location.edit')->with(["name" => $name]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Name $name)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(Name $name)
    {
        //
    }
}
