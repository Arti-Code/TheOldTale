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
                        <i class="far fa-smile text-success"></i>
                    </div>
                    <div class="col-8 progress my-auto  px-0" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $character->happy }}%;"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">

                    </div>
                    <div class="col-8 my-auto">
                        @if($weapon != null)
                            <p>used weapon: {{$weapon->type}}</p>
                        @endif
                    </div>
                </div>
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


@endsection
