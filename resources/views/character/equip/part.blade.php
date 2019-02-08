@extends('layouts.app')

@section('content')

<div class="card bg-light">
<div class="card-header"><h5>{{ucfirst(App\User::DIC($part))}}: dostępne przedmioty</h5></div>
    <div class="card-body">
        <form class="form" action="{{ route('character.equip.update') }}" method="post">
            @csrf
            <div class="form-group mx-auto">
                <select id="weared" name="weared" class="form-control w-50 mx-auto">
                    @if(!empty($weared))
                        <option value="{{ $weared->id }}" selected>{{ $weared->type }}</option>
                        <option value="">brak</option>
                    @else
                        <option value="null" selected>brak</option>
                    @endif
                    @foreach ($wearable as $item)
                        <option value="{{ $item->id }}">{{ $item->type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="hidden" class="form-control" name="bodyPart" id="bodyPart" value="{{ $part }}">
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary mx-auto">Załóż przedmiot</button>
            </div>
        </form>
    </div>
</div>

@endsection