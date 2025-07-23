@php
    
    $html = $email_content->content;
    $html = Str::replace('--AD_SOYAD--',$user->name,$html);


@endphp

{!! $html !!}