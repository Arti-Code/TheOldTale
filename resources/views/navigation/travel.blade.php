@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header text-center">
        <h5>travel</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3 text-center">
                {{ $start_name }}
            </div>
            <div class="progress col-6 my-auto">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
            </div>
            <div class="col-3 text-center">
                {{ $finish_name }}
            </div>
        </div>
    </div>
</div>


@endsection
