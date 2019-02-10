@extends('layouts.app')

@section('content')

<div class="d-flex flex-row justify-content-center">

    <div class="d-flex flex-column justify-content-center">
        @if(!empty($equiped["weapon"]))
    <a href="{{route("character.equip.part", "weapon")}}"><div class="flex-item part mx-auto" name="weapon" id="weapon"><img src="{{asset('png/' . $equiped["weapon"] . '64.png')}}" /></div></a>
        @else
            <a href="{{route("character.equip.part", "weapon")}}"><div class="flex-item part mx-auto" name="weapon" id="weapon"></div></a>
        @endif
    </div>

    <div class="d-flex flex-column human-bg justify-content-between">

        @if(!empty($equiped["head"]))
            <a href="{{route("character.equip.part", "head")}}"><div class="flex-item part mx-auto" name="head" id="head"><img src="{{asset('png/' . $equiped["head"] . '64.png')}}" /></div></a>
        @else
            <a href="{{route("character.equip.part", "head")}}"><div class="flex-item part mx-auto" name="head" id="head"></div></a>
        @endif

        @if(!empty($equiped["body"]))
            <a href="{{route("character.equip.part", "body")}}"><div class="flex-item part mx-auto" name="body" id="body"><img src="{{asset('png/' . $equiped["body"] . '64.png')}}" /></div></a>
        @else
            <a href="{{route("character.equip.part", "body")}}"><div class="flex-item part mx-auto" name="body" id="body"></div></a>
        @endif
        
        <a href="{{route("character.equip.part", "legs")}}"><div class="flex-item part mx-auto" name="legs" id="legs">{{$equiped["legs"]}}</div></a> 
        
        @if(!empty($equiped["foots"]))
            <a href="{{route("character.equip.part", "foots")}}"><div class="flex-item part mx-auto" name="foots" id="foots"><img src="{{asset('png/' . $equiped["foots"] . '64.png')}}" /></div></a>
        @else
            <a href="{{route("character.equip.part", "foots")}}"><div class="flex-item part mx-auto" name="foots" id="foots"></div></a>
        @endif

    </div>

    <div class="d-flex flex-column justify-content-center">
        <a href="{{route("character.equip.part", "shield")}}"><div class="flex-item part mx-auto" name="shield" id="shield">{{$equiped["shield"]}}</div></a>
    </div>

</div>

@endsection