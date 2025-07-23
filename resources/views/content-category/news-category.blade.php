<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">

    @php
        $categorySubTitle = isset($content->additional['subTitle']) ? Str::replace('---CONTENTS_COUNT---','<span class="badge bg-secondary mx-2 p-2 p-responsive">'.$content->contents_count.'</span>',$content->additional['subTitle']) : "";
    @endphp

    <x-page-header 
        :header-video="$content->main_video->first()" 
        :title="isset($content->additional['customTitle']) && $content->additional['customTitle'] === true && $content->additional['customTitleText'] ? $content->additional['customTitleText'] : $content->name"
        :header-image="$content->header_image->first()" 
        :parent-title="$content->parent ? $content->parent->name : ''" 
        :sub-title="$categorySubTitle" 
        :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]"
    />

    @if ($content->content && count($content->content) > 0)
        @foreach ($content->content as $section)
        <x-section :section="$section" :content="$content"/>
        @endforeach
    @endif

    @php
        $customCardLayout = null;
        if(isset($content->additional['cardLayout']) && !empty($content->additional['cardLayout'])){
            $cardLayout = \App\Models\CardLayout::find($content->additional['cardLayout']);
            if( $cardLayout ){
                $customCardLayout = $cardLayout;
            }
        }
    @endphp

    <x-content-list :category="$content" :use-date="true" :card-layout="$customCardLayout"/>

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