@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('character.store') }}">
    @csrf
    <div class="card bg-light">
    <div class="card-header">Nowa Postac</div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Nazwa</label>
            <small><i>(4-10 liter, pierwsza duża)</i></small>
            <input name="name" id="name" type="text" class="form-control" minlength="4" maxlength="10" pattern="^[A-Z][a-z]{4,10}$" required>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sex" id="maleRadio" value="M" checked>
            <label class="form-check-label" for="maleRadio">Mężczyzna</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sex" id="femaleRadio" value="F">
            <label class="form-check-label" for="femaleRadio">Kobieta</label>
        </div>
        <div class="form-group">
            <label>Universum</label>
            <select id="universum_id" name="universum_id" class="form-control">
                @foreach ($universums as $universum)
                    <option value="{{ $universum->id }}">{{ $universum->name }} (tura: {{ $universum->turn }})</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex flex-row justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkSTR" name="checkSTR">
                <label class="form-check-label" for="defaultCheck1">
                    Siła
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkDEX" name="checkDEX">
                <label class="form-check-label" for="defaultCheck1">
                    Zwinność
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkDUR" name="checkDUR">
                <label class="form-check-label" for="defaultCheck1">
                    Wytrzymałość
                </label>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkINTEL" name="checkINTEL">
                <label class="form-check-label" for="defaultCheck1">
                    Inteligencja
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkWILL" name="checkWILL">
                <label class="form-check-label" for="defaultCheck1">
                    Siła Woli
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkPERC" name="checkPERC">
                <label class="form-check-label" for="defaultCheck1">
                    Percepcja
                </label>
            </div>
        </div>
        <div class="d-flex">
            <button class="btn btn-success mx-auto" type="submit" name="action">Utworz</button>
        </div>
    </div>
    </div>
</form>

@endsection
