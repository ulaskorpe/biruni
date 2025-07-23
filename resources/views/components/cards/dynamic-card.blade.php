@if ($cardLayout->json_data['link_to_content'] && $cardLayout->json_data['link_to_content'] === true && $content->uri)
    
    <a href="{{$content->uri->final_uri}}" class="text-reset text-decoration-none d-flex h-100 w-100">

        @if ($cardLayout->content && $cardLayout->content[0]['containers'])
        @foreach ($cardLayout->content[0]['containers'][0]['rows'] as $row)
        <x-row :row="$row" :content="$content" :is-layout="true"/>
        @endforeach
        @endif

    </a>

@elseif ($cardLayout->json_data['link_to_content'] && $cardLayout->json_data['link_to_content'] === true && $content->content_type->offcanvas === true)

    <div class="d-flex h-100 w-100 cursor-pointer" onclick="openOffcanvasContent('{{$content->uuid}}','{{$content->language}}','{{$content->name}}')">

        @if ($cardLayout->content && $cardLayout->content[0]['containers'])
        @foreach ($cardLayout->content[0]['containers'][0]['rows'] as $row)
        <x-row :row="$row" :content="$content" :is-layout="true"/>
        @endforeach
        @endif

    </div>

@elseif ($cardLayout->json_data['link_to_depending_content'] && $cardLayout->json_data['link_to_depending_content'] === true && $content->depending_content && $content->depending_content->uri)
    
    <a href="{{$content->depending_content->uri->final_uri}}" class="text-reset text-decoration-none w-100">

        @if ($cardLayout->content && $cardLayout->content[0]['containers'])
        @foreach ($cardLayout->content[0]['containers'][0]['rows'] as $row)
        <x-row :row="$row" :content="$content" :is-layout="true"/>
        @endforeach
        @endif

    </a>

@elseif (isset($cardLayout->json_data['link_to_attribute']) && $cardLayout->json_data['link_to_attribute'] === true && !empty($cardLayout->json_data['linkAttribute'] && $content->attributes))

    @php
        $uri = "#";
        $fancyBox = false;

        $linkAttribute = Arr::first($content->attributes, function ($value, $key) use ($cardLayout) {
            return $value['id'] === $cardLayout->json_data['linkAttribute']['id'];
        });
        
        if( $linkAttribute ){
            
            $uri = $linkAttribute['value'];

            if($cardLayout->json_data['linkAttributeFancyBox']){
                $fancyBox = true;
            }

        }

    @endphp

    <a href="{{$uri}}" class="text-reset text-decoration-none w-100" @if ($fancyBox) data-fancybox @endif>

        @if ($cardLayout->content && $cardLayout->content[0]['containers'])
        @foreach ($cardLayout->content[0]['containers'][0]['rows'] as $row)
        <x-row :row="$row" :content="$content" :is-layout="true"/>
        @endforeach
        @endif

    </a>

@else

    @if ($cardLayout->content && $cardLayout->content[0]['containers'])
    @foreach ($cardLayout->content[0]['containers'][0]['rows'] as $row)
    <x-row :row="$row" :content="$content" :is-layout="true"/>
    @endforeach
    @endif

@endif