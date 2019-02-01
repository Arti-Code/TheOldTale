<div class="d-flex flex-row justify-content-around py-2 my-1 border align-items-center">

    <div class="col-2 d-flex py-auto">
        {{ $title }}
    </div>

    <div class="progress col-6 my-auto px-0" style="height: 4px;">

        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $slot }}%">
        
        </div>

    </div>

    <div class="col-2 text-center align-center">
    <a href="{{ route('progress.destroy') }}"><i class="far fa-times-circle red"></i></a>
    </div>

</div>