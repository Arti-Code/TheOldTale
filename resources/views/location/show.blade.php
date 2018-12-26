@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <img class="card-img-top" src="{{ asset('png/'. $location->type .'.png') }}">
    <div class="card-header text-center">
        <h5>{{ $title }}  <a href="{{ route('name.edit', $location->id) }}"><i class="far fa-edit"></i></a></h5>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col justify-content-center">{{ $location->type }}</div>
    </div>
    </div>
</div>


@endsection
