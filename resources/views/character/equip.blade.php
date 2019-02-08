@extends('layouts.app')

@section('content')

<div class="flex-container">
    <a class="flex-item part" href="{{route("character.equip.part", "head")}}"><div name="head" id="head">{{$equiped["head"]}}</div></a>
    <a class="flex-item part" href="{{route("character.equip.part", "body")}}"><div name="body" id="body">{{$equiped["body"]}}</div></a>
    <a class="flex-item part" href="{{route("character.equip.part", "legs")}}"><div name="legs" id="legs"></div></a> 
    <a class="flex-item part" href="{{route("character.equip.part", "foots")}}"><div name="foots" id="foots"></div></a>
</div>

@endsection