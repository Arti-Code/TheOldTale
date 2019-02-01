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
        <h6 id="lbl"></h6>
        <div class="d-flex flex-row justify-content-between my-2">
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="" id="checkSTR" name="checkSTR" onchange="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Siła
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="" id="checkDEX" name="checkDEX" onchange="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Zwinność
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="" id="checkDUR" name="checkDUR" onchange="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Wytrzymałość
                </label>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between my-2">
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="" id="checkINTEL" name="checkINTEL" onchange="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Inteligencja
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="" id="checkWILL" name="checkWILL" onchange="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Siła Woli
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="" id="checkPERC" name="checkPERC" onchange="countTalents()">
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

<script>
    var check = [];
    var numTalents = 0;
    document.addEventListener("DOMContentLoaded", function(event)
    {
        
        check[0] = document.getElementById("checkSTR");
        check[1] = document.getElementById("checkDEX");
        check[2] = document.getElementById("checkDUR");
        check[3] = document.getElementById("checkINTEL");
        check[4] = document.getElementById("checkWILL");
        check[5] = document.getElementById("checkPERC");
        lbl = document.getElementById("lbl");

        lbl.innerHTML = "Wybierz dwie cechy które są dla Ciebie najważniejsze (" + numTalents + ")";

        
    });

    function countTalents()
    {
        numTalents = 0;
        for (let index = 0; index < 6; index++) {
            if(check[index].checked == true)
                numTalents = numTalents + 1;
            else
                numTalents = numTalents - 1;
        }
        lbl.innerHTML = "Wybierz dwie cechy które są dla Ciebie najważniejsze (" + numTalents + ")";
    }
</script>