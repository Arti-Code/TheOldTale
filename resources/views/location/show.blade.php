@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <img class="card-img-top" src="{{ asset('png/'. $location->type .'.png') }}">
    <div class="card-header text-center">
        <h5>{{ $title }}  <a href="{{ route('name.edit', $location->id) }}"><i class="far fa-edit"></i></a></h5>
    </div>
    <div class="card-body d-flex justify-content-center">
        @foreach ($people as $p)
            <div class="card avatar m-1 bg-light">
                <img class="card-img-top card-avatar" src=" {{asset('png/avatar00.png') }}">
                <div class="card-header p-0 border-0 bg-light text-center"><small>{{ $p->name }}</small></div>
            </div>
        @endforeach
    </div>
</div>

@endsection
