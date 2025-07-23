@php

    $elemDivClasses = [];

    if( $data ) {
        if($data['baseDesignOptions']['class']) $elemDivClasses[] = $data['baseDesignOptions']['class'];

        foreach ($data['baseDesignOptions']['margin'] as $key => $value) {
            if($value) $elemDivClasses[] = $value;
        }
        foreach ($data['baseDesignOptions']['padding'] as $key => $value) {
            if($value) $elemDivClasses[] = $value;
        }
    }

@endphp

<div @class($elemDivClasses)>
    <form action="{{route('newsletter-members.store')}}" method="POST" class="needs-validation" novalidate>
        @csrf
        @honeypot
        <div class="d-flex flex-row flex-nowrap rounded bg-transparent align-items-center">
            <input type="email" class="form-control bg-transparent rounded-end-0 border-end-0 outline-none flex-grow-1 shadow-none newsletter-email" name="email" placeholder="{{ __('E-Posta Adresiniz') }}" required>
            <div>
                <button type="submit" class="btn btn-primary rounded-end rounded-start-0">
                    <img class="img-fluid" src="/media/2025/3/3/arrow-whitesvg.svg" width="31" height="30">
                </button>
            </div>
        </div>
    </form>
</div>