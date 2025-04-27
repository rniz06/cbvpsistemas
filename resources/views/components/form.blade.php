<div class="card card-{{ $color ?? 'success' }} {{ $class ?? '' }}">
    <div class="card-header">
        <h3 class="card-title"> {{ $title ?? 'Registrar' }} </h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="{{ $method ?? 'POST' }}" action="{{ $action ?? '#' }}">
        @csrf
        <div class="card-body">
            {{ $slot }}
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{ $buttons ?? '' }}
        </div>
        <!-- /.card-footer -->
    </form>
</div>