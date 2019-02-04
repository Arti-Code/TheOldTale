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
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center">{{$item->type}}</td>
                            <td class="text-center">{{$item->amount}}</td>
                            <td class="text-center"><a href="{{route('item.show', $item->id)}}"><i class="green fas fa-long-arrow-alt-up"></i><i class="red fas fa-long-arrow-alt-down"></i></a></td>
                            @if( array_key_exists($item->type, App\Item::GET_ALL_FOOD()) )
                                <td class="text-center"><a href="{{route('character.eat', $item->id)}}"><i class="blue fas fa-utensils"></i></a></td>
                            @elseif( array_key_exists($item->type, App\Item::GET_ALL_WEAPONS()) )
                                <td class="text-center"><a href="{{route('character.weapon.equip', $item->id)}}"><i class="fas fa-shield-alt"></i></a></td>
                            @else
                                <td class="text-center"></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
