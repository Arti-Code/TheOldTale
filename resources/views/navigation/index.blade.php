@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header text-center">
        <h5 class="">{{ $location_name }}</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <tbody>
                @foreach ($routes as $route)
                    <tr>
                        <td>{{ $route['finish'] }}</td>
                        <td>{{ $route['type'] }}</td>
                        <td>{{ $route['distance'] }}</td>
                        <td>
                            <a href="{{ route('navigation.select', $route['id']) }}"><i class="fas fa-hiking"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
