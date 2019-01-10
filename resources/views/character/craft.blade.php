@extends('layouts.app')

@section('content')

@if (count($products) > 0)
<div class="card bg-light">
    <div class="card-header text-center"><h5>Wytwarzaj przedmiot</h5></div>
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
                @foreach ($products as $k => $p)
                    <tr>
                        <td>{{ $k }}</td>
                        <td class="text-center">{{ $p['turn'] }}</td>
                        <td>
                        @foreach ( $p['res'] as $l => $r )
                            {{$l . '(' . $r . ') ' }}
                        @endforeach
                        </td>
                        <td class="text-center"><a href="{{ route('progress.craft', $k) }}"><i class="green fas fa-hammer"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
