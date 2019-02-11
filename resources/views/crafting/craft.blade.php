@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header text-center"><h5>Wytwarzaj {{$item['name']}}</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('character.store') }}">
            @csrf
            <input type="hidden" name="item_name" id="item_name" value="{{$item['name']}}">
            @foreach( $inventory as $inv )
                <div class="row mt-2">
                    <div class="col-3 text-center"></div>
                    <div class="col-6 text-center">
                        <span>{{$inv->type}}</span>
                        <span id="quant"></span>
                    </div>
                    <div class="col-3 text-center"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 text-right"><span>postac</span></div>
                    <div class="col-6 my-auto">
                        <input type="range" class="custom-range" name="slider" id="slider" min="0" value="{{$item['res'][$inv->type]}}" max="{{$inv->amount}}">
                    </div>
                    <div class="col-3 text-left"><span>projekt</span></div>
                </div>
            @endforeach
        </form>
    </div>
</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function(event)
    {
        var slider = document.getElementById("slider");
        var quant = document.getElementById("quant");
        quant.innerHTML = " (" + slider.value + ")";

        slider.oninput = function()
        {
            quant.innerHTML = " (" + this.value + ")";
        }
    });


</script>
