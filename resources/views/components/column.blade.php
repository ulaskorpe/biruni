@php
    
    $display = true;

    if( $isMobile && !$column['settings']['display']['mobile'] ){
        $display = false;
    }

    if( !$isMobile && !$column['settings']['display']['desktop'] ){
        $display = false;
    }

    $classes = [];
    $elemDivClasses = ['d-flex'];

    if( ! $tabOrSlideDiv ) {

        foreach ($column['settings']['size'] as $key => $value) {
            if($value) $classes[] = $value;
        }

        if( isset($column['settings']['sticky']) && $column['settings']['sticky'] ){

            $elemDivClasses[] = 'sticky-top sticky-column';

        } else {

            $elemDivClasses[] = 'position-relative';
            $elemDivClasses[] = 'h-100';

        }
    } else {

        $classes[] = 'position-relative';
        $classes[] = 'h-100';
        $elemDivClasses[] = 'h-100';

    }

    if($column['settings']['class']) $elemDivClasses[] = $column['settings']['class'];

    foreach ($column['settings']['margin'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }
    foreach ($column['settings']['padding'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }
    foreach ($column['settings']['flexDirection'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }

    if(isset($column['settings']['rounded'])) $elemDivClasses[] = $column['settings']['rounded'];

    $columnId = $isLayout ? 'column_'.Str::uuid() : $column['settings']['id'];

@endphp

@if ( $display )

<div @class($classes) id="{{$columnId}}">

    <div @class($elemDivClasses)>

        @if ($column['settings']['background']['color'])
        <div @class(['overlay',$column['settings']['background']['color']])></div>
        @endif

        @if ( isset($column['settings']['background']['dynamic']) && $column['settings']['background']['dynamic'] && $content[$column['settings']['background']['dynamic_image']])
        
            @if ($column['settings']['background']['dynamic_image'] == 'header_video' && isset($content->header_video[0]))
            <video class="bg-video" autoplay muted loop playsinline poster="{{ isset($content->header_image[0]) ? $content->header_image[0]->original_url : '' }}">
                <source src="{{$content->header_video[0]->original_url}}" type="video/mp4">
            </video>
            @else
            @php
                $bgDynamicImage = null;
                if( $column['settings']['background']['dynamic_image'] == 'header_image' && isset($content->header_image[0]) ){
                    $bgDynamicImage = $content->header_image[0];
                }
                if( $column['settings']['background']['dynamic_image'] == 'main_image' && isset($content->main_image[0]) ){
                    $bgDynamicImage = $content->main_image[0];
                }
            @endphp
            @if ($bgDynamicImage)
            <div @class(['overlay',$column['settings']['background']['size'],$column['settings']['background']['position']]) data-bg-image="{{$bgDynamicImage->original_url}}"></div>
            @endif
            @endif
       
        @elseif ($column['settings']['background']['image'])
            <div @class(['overlay',$column['settings']['background']['size'],$column['settings']['background']['position']]) data-bg-image="{{$column['settings']['background']['image']}}"></div>
        @endif

        @if ($column['settings']['background']['layer']['color'])
        <div @class(['overlay',$column['settings']['background']['layer']['color'],$column['settings']['background']['layer']['opacity']])></div>
        @endif
        
        @if (count($column['elements']) > 0)
        
            @foreach ($column['elements'] as $element)
        
            @if (isset($element['layout']) && $element['layout'])

                @switch($element['type'])
                    
                    @case("layout_content")
                        <x-layout-elements.contents :contents="$content->content" />
                    @break

                    @case("layout_title")
                        <x-layout-elements.title :title="$content->name" :element="$element" />
                    @break

                    @case("layout_depending_title")
                    @if ($content->depending_content)
                    <x-layout-elements.title :title="$content->depending_content->name" :element="$element" />
                    @endif
                    @break

                    @case("layout_depending_contents")
                    @if ($content->depending_contents->count() > 0)
                    <x-layout-elements.depending-contents :depending-contents="$content->depending_contents" :element="$element" />
                    @endif
                    @break

                    @case("layout_read_more_button")
                        <x-layout-elements.read-more-button :uri="$content->uri->final_uri ?? '#'" :element="$element" :content-attributes="$content->attributes" />
                    @break

                    @case("layout_meta_data")
                        <x-layout-elements.meta-data :content="$content" :element="$element" />
                    @break

                    @case("layout_summary")
                        <div class="summary">
                        <x-layout-elements.summary :summary="$content->summary" :element="$element" />
                        </div>
                    @break

                    @case("layout_content_attributes")
                        <x-layout-elements.content-attributes :content-attributes="$content->attributes" :element="$element" :content-name="$content->name"/>
                    @break

                    @case("layout_description")
                        <x-layout-elements.description :description="$content->description" :element="$element" />
                    @break

                    @case("layout_mainimage")
                    @if (isset($content->main_image[0]))
                    <x-layout-elements.main-image :media="$content->main_image[0]" :element="$element" :alt="$content->name" :content-attributes="$content->attributes ?? []"/>
                    @endif
                    @break

                    @case("layout_gallery_images")
                    @if ($content->gallery_images->count() > 0)
                    <x-layout-elements.gallery-images :gallery-images="$content->gallery_images" :element="$element"/>
                    @endif
                    @break

                    @case("layout_icon")
                    @if (isset($content->additional['icon']) && !empty($content->additional['icon']))
                    <x-layout-elements.content-icon :icon="$$content->additional['icon']" :element="$element"/>
                    @endif
                    @break

                    @default
                        
                @endswitch

            @elseif (isset($element['widget']) && $element['widget'])

                <x-widget.widget :widget="$element" :content="$content"/>

            @elseif (isset($element['render_blade']) && $element['render_blade'])
                
                <x-elements.index :element="$element" :content="$content"/>
            
            @else

                {!! generateElementHtml($element['data']['elemHtml'], $content) !!}

            @endif
    
            @endforeach
        
        @endif

    </div>

</div>
    
@endif