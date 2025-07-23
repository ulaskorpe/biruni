@php

$sale_contract_page = null;

if($settings->sale_contract_page){
    $sale_contract_page = \App\Models\Content::where('uuid',$settings->sale_contract_page)->first();
}

@endphp

@if ($sale_contract_page)
<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" role="switch" id="mesafeli-satis-switch" required name="mesafeli" @checked(old('mesafeli'))>
    <label class="form-check-label" for="mesafeli-satis-switch"><a href="#offcanvas-mesafeli" data-bs-toggle="offcanvas" role="button">Mesafeli satış sözleşmesini</a> okudum, onaylıyorum.</label>
    <div class="invalid-feedback">{{ __('Satış sözleşmesini onaylayınız...') }}</div>
</div>
@endif

@if ($sale_contract_page)
<div class="offcanvas offcanvas-size-xxl offcanvas-end" tabindex="-1" id="offcanvas-mesafeli">
    <div class="offcanvas-header">
        <span class="h4 offcanvas-title">{{$sale_contract_page->name}}</span>
        <button type="button" class="btn btn-white btn-link p-0" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="bi bi-x-lg fs-4"></i></button>
    </div>
    <div class="offcanvas-body">
        {!! $sale_contract_page->description !!}
    </div>
</div>
@endif