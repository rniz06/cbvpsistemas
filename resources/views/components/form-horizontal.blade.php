<div class="card card-{{ $color ?? 'success' }} {{ $class ?? '' }}">
    <div class="card-header">
        <h3 class="card-title"> {{ $title ?? 'Titulo' }} </h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="{{ $method ?? 'POST' }}" action="{{ $action ?? '#' }}"
        @if (isset($wireSubmit)) wire:submit="{{ $wireSubmit }}" @endif>
        @csrf
        <div class="card-body">
            {{ $slot }}
        </div>
        <!-- /.card-body -->
        @if (isset($buttons))
            <div class="card-footer">
                {{ $buttons }}
            </div>
        @endif
        <!-- /.card-footer -->
    </form>
</div>
