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
               <!-- <a href=""><div class="d-inline bg-light border p-1 font-weight-bold rounded">{ $msg->character->name }}:</div></a> <div class="d-inline font-italic">{ $msg->text }}</div> <br />-->
               <a href="{{route('character.other', $msg->character->id)}}" class="btn btn-outline-secondary py-0">{{ $msg->character->name }}</a> <div class="d-inline font-italic">{{ $msg->text }}</div> <br />
            </div>
        </div>
    @else
        @if($msg->type == "FIGHT")
            <div class="card border-0">
                <div class="card-body py-1">
                    <div><i class="red fas fa-exclamation"></i><b class="red">  {{ $msg->text }}</b></div>
                </div>
            </div>
        @elseif($msg->type == "GLOBAL")
            <div class="card border-0">
                <div class="card-body py-1">
                    <div class="font-weight-bold text-center blue">  {{ $msg->text }}</div>
                </div>
            </div>
        @else
            <div class="card border-0">
                <div class="card-body py-1">
                    <div><b class="text-muted">  {{ $msg->text }}</b></div>
                </div>
            </div>
        @endif

    @endif
@endforeach

@endsection
