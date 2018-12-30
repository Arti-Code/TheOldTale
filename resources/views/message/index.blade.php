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
        <div class="card mt-2">
            <div class="card-body py-1">
                <b>{{ $msg->character->name }}:</b> <i>{{ $msg->text }}</i> <br />
            </div>
        </div>
    @else
        <div class="card mt-2">
            <div class="card-body py-1">
                <b>{{ $msg->text }}</b> <br />
            </div>
        </div>
    @endif
@endforeach

@endsection
