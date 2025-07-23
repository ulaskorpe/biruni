<div @class(['alert alert-danger rounded-0', 'position-fixed zindex-3 mb-0 w-100 start-0 bottom-0' => $isMobile]) role="alert">
    <div class="container large-container d-flex align-items-center justify-content-between gap-3">
        <ul class="mb-0 text-start list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>