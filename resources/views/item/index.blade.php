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
                            <td class="text-center"><a href="{{route('item.show', $item->id)}}"><i class="red far fa-arrow-alt-circle-down"></i></a></td>
                            @if( in_array($item->type, App\Item::FOOD) )
                                <td class="text-center"><a href="{{route('character.eat', $item->id)}}"><i class="blue fas fa-utensils"></i></a></td>
                            @elseif( array_key_exists($item->type, App\Item::WEAPON) )
                                <td class="text-center"><a href="{{route('character.weapon.equip', $item->id)}}"><i class="fas fa-shield-alt"></i></a></td>
                            @else
                                <td class="text-center"></td>
                            @endif
                            <td class="text-center"><i class="green fas fa-hammer"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
