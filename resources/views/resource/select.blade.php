@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header text-center">
        <h5>{{$resource->title}}</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('resource.store') }}">
            @csrf
            <input type="hidden" name="res_id" id="res_id" value="{{$resource->id}}">
            <input type="hidden" name="res_t" id="res_t" value="{{$resource->turns}}">
            <div class="row mt-2">
                <div class="col-3 text-center">
                    <label id="turns" name="turns">{{$resource->turns}} h/cykl</label>
                </div>
                <div class="col-6 text-center">
                    <label id="cycles" name="cycles"></label>
                </div>
                <div class="col-3 text-center">
                    <label id="total" name="total"></label>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-2 text-right">
                    <div><i class="green fas fa-arrow-circle-up"></i></div>
                </div>
                <div class="col-8 my-auto">
                    <input type="range" class="custom-range" name="slider" id="slider" min="1" value="1" max="10">
                </div>
                <div class="col-2 text-left">
                    <div><i class="red fas fa-arrow-circle-down"></i></div>
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
        var turns = document.getElementById("res_t");
        var cycles = document.getElementById("cycles");
        var total = document.getElementById("total");
        cycles.innerHTML = "cykle: " + slider.value;
        total.innerHTML = "całkowity czas: " + slider.value * res_t.value;
        slider.oninput = function()
        {
            cycles.innerHTML = "cykle: " + this.value;
            total.innerHTML = "całkowity czas: " + this.value * res_t.value + "h";
        }
    });


</script>
