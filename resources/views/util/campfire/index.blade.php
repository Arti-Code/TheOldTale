@extends('layouts.app')

@section('content')

@if (count($products) > 0)
<div class="card bg-light">
    <div class="card-header text-center"><h5>Campfire</h5></div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th class="text-center">Czas produkcji</th>
                    <th>Surowce</th>
                    <th class="text-center">Wytwarzaj</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td class="text-center">{{ $value['turn'] }}</td>
                        <td>
                            @foreach ( $value['res'] as $key2 => $value2 )
                                {{$key2 . '(' . $value2 . ') ' }}
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="{{ route('progress.craft', [ "name" => $key, "util_id" => $util->id ]) }}"><i class="green fas fa-hammer"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
