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
                <input class="form-check-input" type="checkbox" value="str" id="talent[0]" name="talent[0]" onClick="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Siła
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="dex" id="talent[1]" name="talent[1]" onClick="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Zwinność
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="dur" id="talent[2]" name="talent[2]" onClick="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Wytrzymałość
                </label>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between my-2">
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="intel" id="talent[3]" name="talent[3]" onClick="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Inteligencja
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="will" id="talent[4]" name="talent[4]" onClick="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Siła Woli
                </label>
            </div>
            <div class="form-check col-3">
                <input class="form-check-input" type="checkbox" value="perc" id="talent[5]" name="talent[5]" onClick="countTalents()">
                <label class="form-check-label" for="defaultCheck1">
                    Percepcja
                </label>
            </div>
        </div>
        <div class="d-flex">
            <button class="btn btn-success mx-auto" type="submit" id="action" name="action">Utworz Nową Postać</button>
        </div>
    </div>
    </div>
</form>

@endsection

<script>
    var talent = [];
    var numTalents = 0;
    var btn;
    document.addEventListener("DOMContentLoaded", function(event)
    {
        for (let i = 0; i < 6; i++) 
        {
            talent[i] = document.getElementById("talent[" + i + "]");          
        }
        lbl = document.getElementById("lbl");
        btn = document.getElementById("action");
        lbl.innerHTML = "Wybierz dwie cechy które są dla Ciebie najważniejsze (" + numTalents + ")";
        btn.disabled = true;
        
    });

    function countTalents()
    {
        numTalents = 0;
        for (let index = 0; index < 6; index++) {
            if(talent[index].checked == true)
                numTalents = numTalents + 1;
        }
        lbl.innerHTML = "Wybierz dwie cechy które są dla Ciebie najważniejsze (" + numTalents + ")";
        if(numTalents == 2)
            btn.disabled = false;
        else
            btn.disabled = true;
    }
</script>