@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header text-center">
        <h5>travel</h5>
    </div>
    <div class="card-body">
        <div class="row py-2">
            <div class="col-3 d-flex py-auto">
                {{ $start_name }}
            </div>
            <div class="progress col-6 my-auto px-0">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
            </div>
            <div class="col-3 text-center align-center">
                {{ $finish_name }}
            </div>
        </div>
        <div class="row d-flex">
            <div class="col d-flex pb-1">
                <a class="btn btn-light border mx-auto" href="{{ route('navigation.back') }}">
                    <i class="fas fa-undo-alt red"></i>
                </a>
            </div>
        </div>
    </div>

</div>


@endsection
