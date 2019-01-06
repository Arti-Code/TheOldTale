@extends('layouts.app')

@section('content')

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
                @if( $progress != null )
                    <div class="row">
                        <div class="col-2">
                            @if( $progress['type'] == 'craft' )
                                <i class="fas fa-hammer"></i>
                            @elseif( $progress['type'] == 'travel' )
                                <i class="fas fa-hiking"></i>
                            @elseif( $progress['type'] == 'collect' )
                                <i class="fas fa-apple-alt"></i>
                            @endif
                        </div>
                        <div class="col-8 progress my-auto  px-0" style="height: 4px;">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $progress['value'] }}%;"></div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-3 justify-content-center">
                <div class="card avatar">
                    <img class="card-img-top card-avatar" src="{{asset('png/avatar' . $character->sex . '.png')}}">
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
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Skills</div>
    </div>
    <div class="card p-2 bg-light">
        <a href="{{route('item.index')}}"><img class="card-img-top" src="{{asset('png/backpack.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Inventory</div>
    </div>
    <div class="card p-2 bg-light">
        <a href="{{route('character.craft')}}"><img class="card-img-top" src="{{asset('png/craft.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Craft</div>
    </div>
</div>

@endsection
