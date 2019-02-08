@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-6">
        <div class="flex-container">
            <div class="flex-item body mx-4" name="body" id="body"><a href="{{route("character.equip.part", "weapon")}}"><img src="{{asset('png/' . $equiped["weapon"] . '64.png')}}" /></a></div>
        </div>
    </div>



    <div class="col-6">

        <div class="flex-container">
            <div class="flex-item head" name="head" id="head"><a href="{{route("character.equip.part", "head")}}"></a></div>
        </div>

        <div class="flex-container">
            <a href="{{route("character.equip.part", "armr")}}"><div class="flex-item arm" name="armr" id="armr"></div></a>
            <a href="{{route("character.equip.part", "body")}}"><div class="flex-item body" name="body" id="body">{{$equiped["body"]}}</div></a>
            <a href="{{route("character.equip.part", "arml")}}"><div class="flex-item arm" name="arml" id="arml"></div></a>
        </div>

        <div class="flex-container">
            <a href="{{route("character.equip.part", "leg")}}"><div class="flex-item leg" name="leg" id="leg"></div></a>
            <a href="{{route("character.equip.part", "leg")}}"><div class="flex-item leg" name="leg" id="leg"></div></a>
        </div>

        <div class="flex-container">
            <a href="{{route("character.equip.part", "foot")}}"><div class="flex-item foot" name="foot" id="foot"></div></a>
            <a href="{{route("character.equip.part", "foot")}}"><div class="flex-item foot" name="foot" id="foot"></div></a>
        </div>
    </div>
</div>
@endsection