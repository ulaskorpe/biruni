<x-fe-layout :header-layout="$content->header_layout">

    @php
        $categorySubTitle = isset($content->additional['subTitle']) ? Str::replace('---CONTENTS_COUNT---','<span class="badge bg-secondary mx-2 p-2 p-responsive">'.$content->contents_count.'</span>',$content->additional['subTitle']) : "";
    @endphp

    @if (data_get($content->additional, 'hideHeader') === false)
    <x-page-header 
        :header-video="$content->main_video->first()" 
        :title="isset($content->additional['customTitle']) && $content->additional['customTitle'] === true && $content->additional['customTitleText'] ? $content->additional['customTitleText'] : $content->name"
        :header-image="$content->header_image->first()" 
        :parent-title="$content->parent ? $content->parent->name : ''" 
        :sub-title="$categorySubTitle" 
        :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]"
    />
    @endif
    

    @if ($content->content && count($content->content) > 0)
        @foreach ($content->content as $section)
        <x-section :section="$section" :content="$content"/>
        @endforeach
    @endif
    
    @if ($content->content_type->content_category_default_list_type)
    @include('content-category.default-'.$content->content_type->content_category_default_list_type)
    @endif

    <x-slot name="headerScripts">
        @if (isset($content->additional['headerScripts']))
        {!! $content->additional['headerScripts'] !!}
        @endif
    </x-slot>

    <x-slot name="footerScripts">
        @if (isset($content->additional['footerScripts']))
        {!! $content->additional['footerScripts'] !!}
        @endif
    </x-slot>

</x-fe-layout>