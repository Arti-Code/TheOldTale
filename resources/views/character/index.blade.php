@extends('layouts.app')

@section('content')

@if (count($characters) > 0)
<div class="card bg-light">
    <div class="card-header">Select Character</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Universe</th>
                    <th class="text-center">Delete</th>
                    <th class="text-center">Play</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($characters as $character)
                    <tr>
                        <td>{{ $character->name }}</td>
                        <td>{{ $character->universum->name }}</td>
                        <td class="text-center"><a href="{{ route('character.destroy', $character->id) }}"><i class="fas fa-trash-alt"></i></a></td>
                        <td class="text-center"><a href="{{ route('character.select', $character->id) }}"><i class="fas fa-check"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="d-flex mt-3">
    <a class="btn bg-blue text-white mx-auto" href="{{ route('character.create') }}" role="button">Create New Character</a>
</div>

@endsection
