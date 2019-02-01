@extends('layouts.app')

@section('content')

@if(!empty($prog))
    @if($prog["type"] != 'travel')
        @component('layouts.components.progressbar')
            @slot('title')
                {{ $prog["target"] }}
            @endslot
            {{ $prog["bar"] }}
        @endcomponent
    @endif
@endif

<div class="card bg-light">
    <div class="card-header text-center">
        <h5>{{ $character->name }}</h5>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-9">

                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-heart red"></i>
                    </div>
                    <div class="col-8 progress my-auto  px-0" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $character->health }}%;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-utensils text-warning"></i>
                    </div>
                    <div class="col-8 progress my-auto  px-0" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $character->satiety }}%;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <i class="far fa-smile text-success"></i>
                    </div>
                    <div class="col-8 progress my-auto  px-0" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $character->happy }}%;"></div>
                    </div>
                </div>
    
                <div class="row mt-2">
                    <div class="col-12 my-auto">
                        @if($weapon)
                            <b>bron: {{$weapon->type}}</b>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-3 justify-content-center">
                <div class="card avatar">
                    <img class="card-img-top card-avatar" src="{{asset('png/avatar/' . $character->avatar . '.png')}}">
                    <div class="card-header p-0 text-center">
                        @if ($character->sex == "M")
                            <i class="fas fa-mars"></i>
                        @else
                            <i class="fas fa-venus"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="d-flex flex-row justify-content-around my-2 py-2">
    <div class="card p-2 bg-light">
        <img class="card-img-top" src="{{asset('png/skills.png')}}">
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Umiejętności</div>
    </div>
    <div class="card p-2 bg-light">
        <a href="{{route('item.index')}}"><img class="card-img-top" src="{{asset('png/backpack.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Przedmioty</div>
    </div>
    <div class="card p-2 bg-light">
        <a href="{{route('character.craft')}}"><img class="card-img-top" src="{{asset('png/craft.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Wytwarzaj</div>
    </div>
</div>

@endsection
