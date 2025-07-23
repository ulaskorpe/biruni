<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">

    @if (data_get($content->additional, 'hideHeader') === false)
    <x-page-header 
        :header-video="$content->main_video->first()" 
        :title="isset($content->additional['customTitle']) && $content->additional['customTitle'] === true && $content->additional['customTitleText'] ? $content->additional['customTitleText'] : $content->name"
        :header-image="$content->header_image->first()" 
        :parent-title="$content->parent ? $content->parent->name : ''" 
        :sub-title="$content->additional['subTitle'] ?? ''" 
        :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]"
    />
    @endif

    @if ($content->content && count($content->content) > 0)
        @foreach ($content->content as $section)
        <x-section :section="$section" :content="$content"/>
        @endforeach
    @endif

    <x-content-list :category="$content" :use-date="false"/>

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