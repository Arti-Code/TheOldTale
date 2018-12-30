@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <img class="card-img-top" src="{{ asset('png/'. $location->type .'.png') }}">
    <div class="card-header text-center">
        <h5>{{ $title }}  <a href="{{ route('name.edit', $location->id) }}"><i class="far fa-edit"></i></a></h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-row justify-content-center">
            <!--<div  class="col">-->
                @foreach ($res as $r)
                    <div class="card res m-1 bg-light">
                        <img class="card-img-top card-res" src="{{asset('png/' . $r->title . '.png')}}">
                        <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $r->title }}</small></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex flex-row justify-content-around">
            <!--<div  class="col">-->
                @foreach ($people as $p)
                    <div class="card avatar m-1 bg-light">
                        <img class="card-img-top card-avatar" src="{{asset('png/avatar' . $p->sex . '.png')}}">
                        <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $p->name }}</small></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
