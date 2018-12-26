@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body bg-light">
            <h5 class="card-title">Fallen World</h5>
            <p class="card-text">Fallen World is a MMO rpg game with strategy elements based on a web browser. You are welcome! </p>
            <a class="card-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            <a class="card-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </div>
    </div>

@endsection
