@php

    $elemDivClasses = ['hstack'];

    if($data['baseDesignOptions']['class']) $elemDivClasses[] = $data['baseDesignOptions']['class'];

    foreach ($data['baseDesignOptions']['margin'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }
    foreach ($data['baseDesignOptions']['padding'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }

@endphp

<div @class($elemDivClasses)>
    @foreach ($settings->socials as $key => $item)
    <a href="{{$item['value']}}" @class(['box-50 d-flex align-items-center justify-content-center text-dark text-hover-primary'])  target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$item['key']}}">
        <i class="bi bi-{{$item['key']}} fs-5"></i>
    </a>
    @endforeach
</div>