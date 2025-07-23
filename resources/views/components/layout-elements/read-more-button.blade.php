@php
    
    $link = $uri;

    if( $element['data']['linkAttribute'] && $contentAttributes){
        
        $linkAttribute = Arr::first($contentAttributes, function ($value, $key) use ($element) {
            return $value['id'] === $element['data']['linkAttribute']['id'];
        });
        
        if( $linkAttribute ){
            $link = $linkAttribute['value'];
        }
    }

@endphp

{!! Str::replace('--LINK--', $link, $element['data']['elemHtml']) !!}