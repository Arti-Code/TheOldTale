@extends('layouts.app')

@section('content')

<div class="card bg-light">
    <div class="card-header">Universes</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Turn</th>
                    <th class="text-center">Delete</th>
                    <th class="text-center">Calc</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($universums as $universum)
                    <tr>
                        <td>{{ $universum->name }}</td>
                        <td>{{ $universum->turn }}</td>
                        <td class="text-center"><a href=""><i class="fas fa-trash-alt"></i></a></td>
                        <td class="text-center"><a href="{{ route('admin.universum.nextturn', $universum->id) }}"><i class="fas fa-calculator"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex mt-3">
    <a class="btn bg-blue text-white mx-auto" href="" role="button">Utworz Nowe Universum</a>
</div>

@endsection
