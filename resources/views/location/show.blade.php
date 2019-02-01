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
    <img class="card-img-top" src="{{ asset('png/'. $location->type .'.png') }}">
    <div class="card-header text-center">
        <div class="row align-items-center">
            <div class="col-3">

            </div>
            <div class="col-6">
                <h5>{{ $location->name }}</h5>
            </div>
            <div class="col-3">
            
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex flex-row justify-content-center">
            @foreach ($res as $r)
                <div class="card res m-1 bg-light">
                    <a href="{{ route( 'progress.create', [ 'mode' => 'collect', 'id' => $r->id ] ) }}"><img class="card-img-top card-res" src="{{asset('png/' . $r->type . '.png')}}"></a>
                    <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $r->type }}</small></div>
                </div>
            @endforeach
            </div>
        <div class="d-flex flex-row justify-content-center py-2">
            @foreach ($people as $p)
                <div class="card avatar m-1 bg-light">
                    <a href="{{route('character.other', $p->id)}}"><img class="card-img-top card-avatar" src="{{asset('png/avatar/' . $p->avatar . '.png')}}"></a>
                    <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $p->name }}</small></div>
                </div>
            @endforeach
        </div>
        <div class="d-flex flex-row justify-content-center py-2">
            @foreach ($utils as $u)
                <div class="card util m-1 bg-light">
                        <a href="{{route('util.' . $u->type, $u->id)}}"><img class="card-img-top card-util" src="{{asset('png/' . $u->type . '.png')}}"></a>
                        <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $u->type }}</small></div>
                    </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex flex-row justify-content-around my-2 py-2">
    <div class="card p-2 bg-light">
        <a href="{{route('item.location')}}"><img class="card-img-top" src="{{asset('png/create.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Items</div>
    </div>
    <div class="card p-2 bg-light">
        <a href="{{ route('navigation.index') }}"><img class="card-img-top" src="{{asset('png/travel.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Travel</div>
    </div>
    <div class="card p-2 bg-light">
        <a href="{{route('util.location.list', $location->id)}}"><img class="card-img-top" src="{{asset('png/build.png')}}"></a>
        <div class="card-header p-0 bg-light border-0 text-center font-weight-bold">Construct</div>
    </div>
</div>

@endsection
