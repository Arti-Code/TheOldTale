@extends('layouts.app')

@section('content')

@if( $items != null)
    <div class="card mt-2">
        <div class="card-header text-center">
            <h6>Items</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">type</th>
                        <th class="text-center">amount</th>
                        <th class="text-center">drop off</th>
                        <th class="text-center">use</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center">{{$item->type}}</td>
                            <td class="text-center">{{$item->amount}}</td>
                            <td class="text-center"><a href="{{route('item.show', $item->id)}}"><i class="red far fa-arrow-alt-circle-down"></i></a></td>
                            <td class="text-center"><i class="green fas fa-hammer"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
