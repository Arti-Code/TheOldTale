@extends('layouts.app')

@section('content')

@if (count($utils) > 0)
<div class="card bg-light">
    <div class="card-header text-center"><h5>Buduj</h5></div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th class="text-center">Tury</th>
                    <th>Surowce</th>
                    <th>Narzędzia</th>
                    <th class="text-center">Buduj</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($utils as $key => $val)
                    <tr>
                        <td>{{ $key }}</td>
                        <td class="text-center">{{ $val['turns'] }}</td>
                        <td>
                        @foreach ( $val['building'] as $l => $r )
                            {{$l . '(' . $r . ') ' }}
                        @endforeach
                        </td>
                        <td>
                        @foreach ( $val['tool'] as $m => $t )
                            {{$m . ' '}}
                        @endforeach
                        </td>
                        <td class="text-center"><a href=""><i class="green fas fa-hammer"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
