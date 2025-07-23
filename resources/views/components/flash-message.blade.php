@if ($message = Session::get('success'))
<div @class(['alert alert-success rounded-0 mb-0', 'position-fixed zindex-3 mb-0 w-100 start-0 bottom-0' => $isMobile]) role="alert">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill text-success fs-4"></i>
            <div>{{$message}}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div @class(['alert alert-danger rounded-0 mb-0', 'position-fixed zindex-3 mb-0 w-100 start-0 bottom-0' => $isMobile]) role="alert">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-x-circle-fill text-danger fs-4"></i>
            <div>{{$message}}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if ($message = Session::get('info'))
<div @class(['alert alert-info rounded-0 mb-0', 'position-fixed zindex-3 mb-0 w-100 start-0 bottom-0' => $isMobile]) role="alert">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill text-info fs-4"></i>
            <div>{{$message}}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if ($errors->any())
<x-errors :errors="$errors" />
@endif