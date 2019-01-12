@extends('layouts.app')

@section('content')

<form class="form-inline pb-5" action="{{ route('message.store') }}" method="post">
    @csrf
    <input type="text" class="form-control mx-auto w-75" name="msgText">
    <input type="hidden" class="form-control" id="charId" value="{{ $character->id }}">
    <button type="submit" class="btn btn-primary">Wyślij</button>
</form>

@foreach($messages as $msg)
    @if($msg->character_id != null)
        <div class="card border-0">
            <div class="card-body py-1">
            @if($msg->type == "CHAR_PRIV" && $msg->character_id != $character->id)
                <i class="blue far fa-eye"> </i><a href="{{route('character.other', $msg->character_id)}}" class="py-0"><u><b> {{ $msg->character->name }}</b></a> <div class="d-inline font-italic"> mowi do Ciebie: {{ $msg->text }}</u></div> <br />
            @elseif($msg->type == "CHAR_PRIV" && $msg->character_id == $character->id)
                <a href="{{route('character.myself')}}" class="py-0"><u><b>{{ $msg->character->name }}</b></a> <div class="d-inline font-italic"> mowi do <a href="{{route('character.other', $msg->receiver_id)}}" class="py-0"><b>{{$msg->receiver_name}}</b></a>: {{ $msg->text }}</u></div> <br />
            @elseif($msg->type == "CHAR_PUB" && $msg->character_id != $character->id)
                <a href="{{route('character.other', $msg->character_id)}}" class="py-0"><b>{{ $msg->character->name }}</b></a> <div class="d-inline font-italic">: {{ $msg->text }}</div> <br />
            @elseif($msg->type == "CHAR_PUB" && $msg->character_id == $character->id)
                <a href="{{route('character.myself')}}" class="py-0"><b>{{ $msg->character->name }}</b></a> <div class="d-inline font-italic">: {{ $msg->text }}</div> <br />
            @endif

            </div>
        </div>
    @else
        @if($msg->type == "FIGHT")
            <div class="card border-0">
                <div class="card-body py-1">
                    <div><i class="red fas fa-exclamation"></i><span class="text-secondary">  {{ $msg->text }}</span></div>
                </div>
            </div>
        @elseif($msg->type == "GLOBAL")
            <div class="card border-0">
                <div class="card-body py-1">
                    <div class="font-weight-bold blue">  {{ $msg->text }}</div>
                </div>
            </div>
        @else
            <div class="card border-0">
                <div class="card-body py-1">
                    <div class="text-muted">  {{ $msg->text }}</div>
                </div>
            </div>
        @endif

    @endif
@endforeach

@endsection
