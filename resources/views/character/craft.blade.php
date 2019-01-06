@extends('layouts.app')

@section('content')

@if (count($products) > 0)
<div class="card bg-light">
    <div class="card-header text-center"><h5>Craft item</h5></div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Turns</th>
                    <th>Resources</th>
                    <th class="text-center">Craft</th>
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
