<?php

namespace App\Http\Controllers;

use App\Message;
use App\Location;
use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check() && session('char_id') != null)
        {
            $character = Character::find(session('char_id'));
            $messages = Message::where('location_id', $character->location_id)->orderBy('added_on', 'desc')->take(15)->get();
            return view('message.index')->with(['character' => $character, 'messages' => $messages]);
        }
        else
        {
            return redirect()->route('welcome')->with('danger', 'Authorization failed or character is not selected');
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
        if(!Auth::check())
            return redirect()->route('welcome')->with('danger', 'Authentication error. You must login.');
        if(!session('char_id'))
            return redirect()->route('character.index')->with('warning', 'Character is not selected.');
        $character = Character::find(session('char_id'));
        $msg = new Message;
        $msg->location_id = $character->location_id;
        $msg->type = 'CHAR_PUB';
        $msg->character_id = $character->id;
        $msg->text = $request['msgText'];
        $msg->save();
        return redirect()->route('message.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
