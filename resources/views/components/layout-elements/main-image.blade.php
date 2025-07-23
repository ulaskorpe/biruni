@if ($media)

    @php
        
        $html = Str::replace('--ALT--', $alt, $element['data']['elemHtml']);
        $html = Str::replace('--ORG_URL--', $media->original_url, $html);

        if( !$element['data']['lightbox'] && $element['data']['linkAttribute'] && count($contentAttributes) > 0){

            $attr = Arr::first($contentAttributes, function ($value, $key) use ($element) {
                return $value['id'] === $element['data']['linkAttribute']['id'];
            });

            if( $attr ){
                $html = Str::replace('--LINK_ATTRIBUTE--', $attr['value'], $html);
            } else {
                $html = Str::replace('--LINK_ATTRIBUTE--', '#', $html);
            }

        }

        if( !empty($element['data']['conversion']) ){

            if( isset($media->conversion_urls[$element['data']['conversion']]) ){
                $html = Str::replace('--CONVERSION_URL--', $media->conversion_urls[$element['data']['conversion']], $html);
            }

        } else {

            $html = Str::replace(9999, $media->custom_properties['width'], $html);
            $html = Str::replace(8888, $media->custom_properties['height'], $html);

        }

    @endphp

    {!! $html !!}

@endif