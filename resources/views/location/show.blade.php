@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <img class="card-img-top" src="{{ asset('png/'. $location->type .'.png') }}">
    <div class="card-header text-center">
        <div class="row align-items-center">
            <div class="col-3">

            </div>
            <div class="col-6">
                <h5>{{ $title }}  <a href="{{ route('name.edit', $location->id) }}"><i class="far fa-edit"></i></a></h5>
            </div>
            <div class="col-3">
                <a href="{{ route('navigation.index') }}"><img src="{{asset('png/routes.png')}}" /></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($prog->type != 'collect')
            <div class="d-flex flex-row justify-content-center">
                @foreach ($res as $r)
                    <div class="card res m-1 bg-light">
                        <a href="{{route('resource.select', $r->id)}}"><img class="card-img-top card-res" src="{{asset('png/' . $r->type . '.png')}}"></a>
                        <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $r->type }}</small></div>
                    </div>
                @endforeach
            </div>
        @elseif($prog->type == 'collect')
            <div class="d-flex flex-row justify-content-around py-2 border align-items-center">
                <div class="col-2 d-flex py-auto">
                    {{ $res->title }}
                </div>
                <div class="progress col-6 my-auto px-0">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="col-2 text-center align-center">
                    <a href="{{route('progress.destroy', $prog->id)}}"><i class="far fa-times-circle red"></i></a>
                </div>
            </div>
        @endif
        <div class="d-flex flex-row justify-content-around py-2">
            @foreach ($people as $p)
                <div class="card avatar m-1 bg-light">
                    <img class="card-img-top card-avatar" src="{{asset('png/avatar' . $p->sex . '.png')}}">
                    <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $p->name }}</small></div>
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
</div>

@endsection
