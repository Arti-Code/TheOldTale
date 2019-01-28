<?php

namespace App\Http\Controllers;

use App\Util;
use App\Character;
use App\LIB;
use Illuminate\Http\Request;

class UtilController extends Controller
{
   
    public function index()
    {

    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(Util $util)
    {
        //
    }

  
    public function edit(Util $util)
    {
        //
    }

 
    public function update(Request $request, Util $util)
    {
        //
    }

 
    public function destroy(Util $util)
    {
        //
    }

    public function list($id)
    {
        $character = Character::find(session('char_id'));
        $utilities = LIB::UTILITIES;
        $utils = [];
        foreach ($utilities as $key => $value) 
        {
            if (in_array('location', $value['inside'])) 
            {
                $utils[$key] = $value;
            }

        }
        return view('util.location.list')->with(["character" => $character, "utils" => $utils]);
    }

    
}
