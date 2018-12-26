@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body bg-light">
            <h5 class="card-title">Begin your adventure!</h5>
            <p class="card-text">To begin your journey, you must select your existing character or create new one. </p>
            <a class="card-link btn btn-primary" href="{{ route('character.index') }}">Select Character</a>
        </div>
    </div>

@endsection
