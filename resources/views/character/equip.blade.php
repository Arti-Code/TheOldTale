@extends('layouts.app')

@section('content')

<div class="d-flex flex-row justify-content-center">

    <div class="d-flex flex-column justify-content-center">
        <a href="{{route("character.equip.part", "weapon")}}"><div class="flex-item part mx-auto" name="weapon" id="weapon">{{$equiped["weapon"]}}</div></a>
    </div>

    <div class="d-flex flex-column human-bg justify-content-between">
        <a href="{{route("character.equip.part", "head")}}"><div class="flex-item part mx-auto" name="head" id="head">{{$equiped["head"]}}</div></a>
        <a href="{{route("character.equip.part", "body")}}"><div class="flex-item part mx-auto" name="body" id="body">{{$equiped["body"]}}</div></a>
        <a href="{{route("character.equip.part", "legs")}}"><div class="flex-item part mx-auto" name="legs" id="legs">{{$equiped["legs"]}}</div></a> 
        <a href="{{route("character.equip.part", "foots")}}"><div class="flex-item part mx-auto" name="foots" id="foots">{{$equiped["foots"]}}</div></a>
    </div>

    <div class="d-flex flex-column justify-content-center">
        <a href="{{route("character.equip.part", "shield")}}"><div class="flex-item part mx-auto" name="shield" id="shield">{{$equiped["shield"]}}</div></a>
    </div>

</div>

@endsection