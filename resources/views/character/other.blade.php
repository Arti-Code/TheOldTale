@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header text-center">
        <h5>{{ $other->name }}</h5>
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
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $other->health }}%;"></div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 my-auto">
                        @if($weapon != null)
                            <b>weapon: {{$weapon->type}}</b>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-3 justify-content-center">
                <div class="card avatar">
                    <img class="card-img-top card-avatar" src="{{asset('png/' . $other->avatar . '.png')}}">
                    <div class="card-header p-0 text-center">
                        @if ($other->sex == "M")
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

<div class="d-flex mt-3">
    <a href="{{route('character.attack', $other->id)}}" class="btn btn-danger mx-auto w-50">Atakuj</a>
</div>



@endsection
