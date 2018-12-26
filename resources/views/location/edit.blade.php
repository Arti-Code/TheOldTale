@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('name.store') }}">
    @csrf
    <div class="card bg-light">
    <div class="card-header">Name this location</div>
    <div class="card-body">
        <div class="form-group">
            <label for="title">Location Name</label>
            @if($name['title'] != null)
                <input name="title" id="title" type="text" class="form-control" value="{{ $name['title'] }}">
            @else
                <input name="title" id="title" type="text" class="form-control" value="">
            @endif
        </div>
        <input type="hidden" id="location_id" name="location_id" value="{{ $name['location_id'] }}">
        <div class="d-flex">
            <a href="" class="btn btn-danger border mx-auto">Cancel</a>
            <button class="btn bg-lime border mx-auto" type="submit" name="action">Rename</button>
        </div>
    </div>
    </div>
</form>

@endsection
