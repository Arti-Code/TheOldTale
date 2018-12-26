<?php

namespace App\Http\Controllers;

use App\Universum;
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
