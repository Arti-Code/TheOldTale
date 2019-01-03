@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h6>{{$item->type}}</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('item.pickup') }}">
            @csrf
            <div class="row">
                <div class="col-4">
                    <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}">
                </div>
                <div class="col-4 text-center">
                    <label id="label"></label>
                </div>
                <div class="col-4">

                </div>
            </div>

            <div class="row">
                <div class="col-2 text-center">
                    min: 0
                </div>
                <div class="col-8 my-auto">
                    <input type="range" class="custom-range" name="amount" id="amount" min="0" value="0" max="{{$item->amount}}">
                </div>
                <div class="col-2 text-center">
                    max: {{$item->amount}}
                </div>
            </div>

            <div class="row">
                <div class="col-4">

                </div>
                <div class="col-4 text-center">
                    <button class="btn btn-warning my-4" type="submit" name="action">Pickup</button>
                </div>
                <div class="col-4">

                </div>
            </div>
        </form>
    </div>
</div>


@endsection

<script>
    document.addEventListener("DOMContentLoaded", function(event)
    {
        console.log("Hello world!");
        var slider = document.getElementById("amount");
        var output = document.getElementById("label");
        output.innerHTML = slider.value;

        slider.oninput = function()
        {
            output.innerHTML = this.value;
        }
    });


</script>
