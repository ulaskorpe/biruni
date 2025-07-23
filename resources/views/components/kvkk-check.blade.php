@php

    $kvkk_page = null;
    $privacy_page = null;
    $membership_page = null;
    $visible = true;

    if($settings->kvkk_page && $form->kvkk_check){
        $kvkk_page = \App\Models\Content::where('uuid',$settings->kvkk_page)->where('language',app()->getLocale())->first();
    }

    if($settings->privacy_page && $form->privacy_check){
        $privacy_page = \App\Models\Content::where('uuid',$settings->privacy_page)->where('language',app()->getLocale())->first();
    }

    if($settings->membership_page && $form->membership_check){
        $membership_page = \App\Models\Content::where('uuid',$settings->membership_page)->where('language',app()->getLocale())->first();
    }

    $random_uuid = Str::uuid();

    if (!$kvkk_page && !$privacy_page && !$membership_page) {
        $visible = false;
    }

@endphp

@if ($visible)
<div class="col-12">

    <div class="vstack gap-2">
        @if ($kvkk_page)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="{{$random_uuid}}-kvkk-check" required>
            <label class="form-check-label" for="{{$random_uuid}}-kvkk-check"><a href="#offcanvas-kvkk-{{$random_uuid}}" class="text-dark" data-bs-toggle="offcanvas" role="button">Kişisel Verilerin Korunması Kanunu</a> Hakkında Bilgilendirme'yi
                okudum.</label>
        </div>
        @endif
        @if ($privacy_page)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="{{$random_uuid}}-privacy-check" required>
            <label class="form-check-label" for="{{$random_uuid}}-privacy-check">
                <a href="#offcanvas-privacy-{{$random_uuid}}" class="text-dark" data-bs-toggle="offcanvas" role="button">Gizlilik ve Güvenlik</a> Hakkında Bilgilendirme'yi
                okudum.</label>
        </div>
        @endif
        @if ($membership_page)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="{{$random_uuid}}-membership-check" required>
            <label class="form-check-label" for="{{$random_uuid}}-membership-check">
                <a href="#offcanvas-membership-{{$random_uuid}}" class="text-dark" data-bs-toggle="offcanvas" role="button">Üyelik Sözleşmesi</a>'ni okudum, onaylıyorum.
            </label>
        </div>
        @endif
    </div>

    @if ($kvkk_page)
    <div class="offcanvas offcanvas-size-xxl offcanvas-end" tabindex="-1" id="offcanvas-kvkk-{{$random_uuid}}">
        <div class="offcanvas-header">
            <span class="h4 offcanvas-title">{{$kvkk_page->name}}</span>
            <button type="button" class="btn btn-white btn-link p-0" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="bi bi-x-lg fs-4"></i></button>
        </div>
        <div class="offcanvas-body" id="mini-cart-body">
            {!! $kvkk_page->description !!}
        </div>
    </div>
    @endif

    @if ($privacy_page)
    <div class="offcanvas offcanvas-size-xxl offcanvas-end" tabindex="-1" id="offcanvas-privacy-{{$random_uuid}}">
        <div class="offcanvas-header">
            <span class="h4 offcanvas-title">{{$privacy_page->name}}</span>
            <button type="button" class="btn btn-white btn-link p-0" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="bi bi-x-lg fs-4"></i></button>
        </div>
        <div class="offcanvas-body">
            {!! $privacy_page->description !!}
        </div>
    </div>
    @endif

    @if ($membership_page)
    <div class="offcanvas offcanvas-size-xxl offcanvas-end" tabindex="-1" id="offcanvas-membership-{{$random_uuid}}">
        <div class="offcanvas-header">
            <span class="h4 offcanvas-title">{{$membership_page->name}}</span>
            <button type="button" class="btn btn-white btn-link p-0" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="bi bi-x-lg fs-4"></i></button>
        </div>
        <div class="offcanvas-body" id="mini-cart-body">
            {!! $membership_page->description !!}
        </div>
    </div>
    @endif

</div>
@endif