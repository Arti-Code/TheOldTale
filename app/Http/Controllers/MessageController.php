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
        $character = Character::find(session('char_id'));
        $messages = Message::where('location_id', $character->location_id)->orWhere('type', 'GLOBAL')->orderBy('added_on', 'desc')->orderBy('id', 'desc')->take(15)->get();
        return view('message.index')->with(['character' => $character, 'messages' => $messages]);
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
        $character = Character::find(session('char_id'));
        $this->ADD_CHAR_PUB_MSG($character->location_id, $character->id, $request['msgText']);
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

    static function ADD_GLOBAL_MSG($univ_id, $text)
    {
        $msg = new Message;
        $msg->universum_id = $univ_id;
        $msg->type = 'GLOBAL';
        $msg->text = $text;
        $time = date("Y-m-d H:i:s");
        $msg->added_on = $time;
        $msg->save();
    }

    static function ADD_FIGHT_MSG($loc_id, $text)
    {
        $msg = new Message;
        $msg->location_id = $loc_id;
        $msg->type = 'FIGHT';
        $msg->text = $text;
        $time = date("Y-m-d H:i:s");
        $msg->added_on = $time;
        $msg->save();
    }

    static function ADD_SYS_PUB_MSG($loc_id, $text)
    {
        $msg = new Message;
        $msg->location_id = $loc_id;
        $msg->type = 'SYS_PUB';
        $msg->text = $text;
        $time = date("Y-m-d H:i:s");
        $msg->added_on = $time;
        $msg->save();
    }

    static function ADD_SYS_PRIV_MSG($loc_id, $rec_id, $text)
    {
        $msg = new Message;
        $msg->location_id = $loc_id;
        $msg->receiver_id = $rec_id;
        $msg->type = 'SYS_PRIV';
        $msg->text = $text;
        $time = date("Y-m-d H:i:s");
        $msg->added_on = $time;
        $msg->save();
    }

    static function ADD_CHAR_PUB_MSG($loc_id, $char_id, $text)
    {
        $msg = new Message;
        $msg->location_id = $loc_id;
        $msg->character_id = $char_id;
        $msg->type = 'CHAR_PUB';
        $msg->text = $text;
        $time = date("Y-m-d H:i:s");
        $msg->added_on = $time;
        $msg->save();
    }
}
