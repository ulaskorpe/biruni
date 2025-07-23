@php
    
    $footerForm = null;

    if( $formid ){

        $footerFormCacheKey = 'footer_form_key_'.app()->getLocale();

        $footerForm = Cache::remember($footerFormCacheKey, now()->addMonth(), function () use ($formid) {
            return \App\Models\Form::where('id',$formid)->first();
        });

    }

@endphp

@if ($footerForm)

    <div class="position-relative">
        <div class="overlay bg-primary h-50 bottom-auto"></div>
        <div class="container position-relative">
            <div class="rounded-5 p-4 p-xl-5 bg-white shadow-sm">

                <div class="d-flex flex-column flex-lg-row g-4 align-items-center justify-content-between mb-5">
                    <div class="mw-xl-50">
                        <p class="h4 text-secondary fwbold">
                            {{ __('Let\'s create your personalized treatment plan.') }}
                        </p>
                        <p class="text-primary">
                            {{ __('There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour') }}
                        </p>
                    </div>
                    @if ($settings->contact['whatsapp'])
                    <a class="d-flex align-items-center gap-2 p-3 text-green-400 text-decoration-none border border-success bg-opacity-10 bg-success rounded fw-bold mw-xl-25" href="https://wa.me/{{ Str::replace(['+',' '],['',''],$settings->contact['whatsapp']) }}" target="_blank">
                        <img src="/media/2025/5/17/whatsapp.svg" alt="Whatsapp" width="44" height="44">
                        <span>
                            {{ __('Or have a preliminary meeting via WhatsApp') }}
                        </span>
                    </a>
                    @endif
                </div>

                <x-form-component :form="$footerForm"/>

            </div>
        </div>
    </div>

@endif