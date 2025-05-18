<div class="card">
    <div class="card-body">
        <div class="row">
            {{ $slot }}
        </div>
    </div>

    <div class="card-footer">
        {{ $buttons ?? '' }}
    </div>
</div>