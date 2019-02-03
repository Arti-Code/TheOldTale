@extends('layouts.app')

@section('content')

@if(!empty($prog))
    @if($prog["type"] != 'travel')
        @component('layouts.components.progressbar')
            @slot('title')
                {{ $prog["target"] }}
            @endslot
            {{ $prog["bar"] }}
        @endcomponent
    @endif
@endif

<div class="card bg-light">
    <div class="card-header text-center">
        <h5>{{ $character->name }}</h5>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach($talents as $key => $value)
                    <div class="row">
                        <div class="col-2 my-1">
                            <img src="{{asset('png/' . $key . '.png')}}">
                        </div>
                        <div class="col-8 progress my-auto  px-0" style="height: 4px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $value }}%;"></div>
                        </div>
                    </div>
                @endforeach
                

            </div>
        </div>
    </div>
    </div>
</div>
   


@endsection
