@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('character.store') }}">
    @csrf
    <div class="card bg-light">
    <div class="card-header">Create new character</div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Character Name</label>
            <input name="name" id="name" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label>Select Universum</label>
            <select id="universum_id" name="universum_id" class="form-control">
                @foreach ($universums as $universum)
                    <option value="{{ $universum->id }}">{{ $universum->name }} (turn: {{ $universum->turn }})</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex">
            <button class="btn bg-lime border mx-auto" type="submit" name="action">Create</button>
        </div>
    </div>
    </div>
</form>

@endsection
