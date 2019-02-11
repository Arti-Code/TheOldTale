@extends('layouts.app')

@section('content')

<div class="container d-flex">
        <a href="{{route('crafting.list', 'clothes')}}" class="btn btn-info w-50 mx-auto my-2">Ubrania</a>
</div>

<div class="container d-flex">
        <a href="{{route('crafting.list', 'weapons')}}" class="btn btn-warning w-50 mx-auto my-2">Broń</a>
</div>

<div class="container d-flex">
        <a href="{{route('crafting.list', 'tools')}}" class="btn btn-secondary w-50 mx-auto my-2">Narzędzia</a>
</div>

@endsection
