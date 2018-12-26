@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header text-center">
        <h5>{{ $character->name }}</h5>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col card-title">{{ $status }}</div>
        </div>
        <div class="row">
            <div class="col-2">
                <i class="fas fa-heart red"></i>
            </div>
            <div class="col-10 progress my-auto  px-0" style="height: 4px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $character->health }}%;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <i class="fas fa-utensils text-warning"></i>
            </div>
            <div class="col-10 progress my-auto  px-0" style="height: 4px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <i class="far fa-smile text-success"></i>
            </div>
            <div class="col-10 progress my-auto  px-0" style="height: 4px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $character->happy }}%;"></div>
            </div>
        </div>
    </div>
    </div>
</div>


@endsection
