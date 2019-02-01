@extends('layouts.app')

@section('content')

<div class="container d-flex">
        <a href="{{route('character.index')}}" class="btn btn-primary w-50 mx-auto my-2">Wybierz Postac</a>
</div>

@if(session('is_admin'))
        <div class="container d-flex">
                <a href="{{ route('admin.universum.index') }}" class="btn btn-warning w-50 mx-auto my-2">Administracja</a>
        </div>
@endif

<div class="container d-flex">
        <a href="{{ route('logout') }}" class="btn btn-danger w-50 mx-auto my-2" 
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
        >
        Wyloguj</a>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
</form>

@endsection
