@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body bg-light">
            <h5 class="card-title">Rozpocznij przygodę!</h5>
            <p class="card-text">Aby rozpocząc, musisz stworzyc nową postac, albo wybrac już istniejącą. </p>
            <a class="card-link btn btn-primary" href="{{ route('character.index') }}">Wybierz Postac</a>
        </div>
    </div>

@endsection
