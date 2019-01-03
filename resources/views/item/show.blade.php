@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header text-center">
        <h5>{{$charItem->type}}</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('item.update') }}">
            @csrf
            <div class="row mt-2">
                <div class="col-3 text-center">
                    <input type="hidden" name="char_item_id" id="char_item_id" value="{{$charItem->id}}">
                    <input type="hidden" name="char_item_val" id="char_item_val" value="{{$charItem->amount}}">
                    <span>character</span>
                </div>
                <div class="col-6 text-center">
                    <label id="label"></label>
                    <input type="hidden" name="item_type" id="item_type" value="{{$charItem->type}}">
                </div>
                <div class="col-3 text-center">
                    <input type="hidden" name="loc_item_id" id="loc_item_id" value="{{$locItem->id}}">
                    <input type="hidden" name="loc_item_val" id="loc_item_val" value="{{$locItem->amount}}">
                    <span>ground</span>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-2 text-right">
                    <div><i class="green fas fa-arrow-circle-up"></i> <span id="charNum">{{$charItem->amount}}</span></div>
                </div>
                <div class="col-8 my-auto">
                    <input type="range" class="custom-range" name="slider" id="slider" min="0" value="{{$locItem->amount}}" max="{{$charItem->amount + $locItem->amount}}">
                </div>
                <div class="col-2 text-left">
                    <div><span id="locNum">{{$locItem->amount}}</span> <i class="red fas fa-arrow-circle-down"></i></div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-3">

                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-success" type="submit" name="action">Accept</button>
                </div>
                <div class="col-3">

                </div>
            </div>
        </form>
    </div>
</div>


@endsection

<script>
    document.addEventListener("DOMContentLoaded", function(event)
    {
        var slider = document.getElementById("slider");
        var charVal = document.getElementById("char_item_val");
        var locVal = document.getElementById("loc_item_val");
        var charNum = document.getElementById("charNum");
        var locNum = document.getElementById("locNum");
        charNum.innerHTML = slider.max - slider.value;
        locNum.innerHTML = slider.value;

        slider.oninput = function()
        {
            charVal.value = this.max - this.value;
            locVal.value = this.value;
            charNum.innerHTML = charVal.value;
            locNum.innerHTML = locVal.value;
        }
    });


</script>
