<div class="js-cookie-consent alert alert-dismissible show bg-dark text-white d-flex flex-column gap-2 position-fixed w-100 w-xl-25 start-0 bottom-0 zindex-3 mb-0" role="alert">
    <strong>{{ trans('cookie-consent::texts.title') }}</strong>
    <p class="cookie-consent__message fs-sm">{!! trans('cookie-consent::texts.message') !!}</p>
    <div>
        <button class="js-cookie-consent-agree cookie-consent__agree btn btn-success btn-sm" type="button">
            {{ trans('cookie-consent::texts.agree') }}
        </button>
    </div>
    <span class="position-absolute top-0 end-0 cursor-pointer m-2" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></span>
</div>