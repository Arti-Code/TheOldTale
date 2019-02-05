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
                <div class="col-6">
                    @foreach($talents as $key => $value)
                        <div class="row">
                            <div class="col-4 my-1 mx-1">
                                <img src="{{asset('png/' . $key . '.png')}}">
                            </div>
                            <div class="col-6 progress my-auto  px-0" style="height: 4px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $value }}%;"></div>
                            </div>
                        </div>
                        @if($key = "dur")
                            </div>
                            <div class="col-6">
                        @endif
                    @endforeach
                    

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    @foreach($skills as $skill)
                        <div class="row">
                            <div class="col-10 my-1 mx-auto">
                                {{$skill["title"]}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10 progress my-auto mx-auto px-0" style="height: 4px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $skill["value"] }}%;"></div>
                            </div>
                        </div>
                        @if($skill["title"] = "drwal")
                            </div>
                            <div class="col-6">
                        @endif
                    @endforeach
                    

                </div>
            </div>
        </div>

    </div>
</div>
   


@endsection
