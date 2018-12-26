@extends('layouts.app')

@section('content')

    <table class="table table-borderless w-75 mx-auto">
        <tbody>
            <?php $j = 0 ?>
            @foreach($log as $l)
                <tr>
                    <td class="py-0">{{ $j }}.</td>
                    <td class="py-0">{{ $l }}</td>
                </tr>
                <?php $j++ ?>
            @endforeach
        </tbody>
    </table>

    <div>
        <a class="btn btn-info text-white">OK</a>
    </div>

@endsection
