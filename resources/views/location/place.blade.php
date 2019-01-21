@extends('layouts.app')

@section('content')

@for ($i = 0; $i < 6; $i++)
    <div class="row">
    @for ($j = 0; $j < 6; $j++)
        <div class="col-2">
            col
        </div>
    @endfor
    </div>
@endfor

@endsection
