@extends('layouts.app')

@section('content')

@if (isset($characters))
<div class="card bg-light">
    <div class="card-header">Select Character</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Imię</th>
                    <th>Universum</th>
                    <th class="text-center">Wybierz</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($characters as $character)
                    <tr>
                        <td>{{ $character->name }}</td>
                        <td>{{ $character->universum->name }}</td>
                        @if($character->dead == 0)
                            <td class="text-center"><a href="{{ route('character.select', $character->id) }}"><i class="fas fa-check"></i></a></td>
                        @else
                            <td class="text-center"><i class="red fas fa-skull"></i></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="d-flex mt-3">
    <a class="btn bg-blue text-white mx-auto" href="{{ route('character.create') }}" role="button">Utworz Nowy Charakter</a>
</div>

@endsection
