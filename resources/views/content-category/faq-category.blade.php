<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">

    <x-page-header 
        :header-video="$content->main_video->first()" 
        :title="isset($content->additional['customTitle']) && $content->additional['customTitle'] === true ? $content->additional['customTitleText'] : $content->name"
        :header-image="$content->header_image->first()" 
        :parent-title="$content->parent ? $content->parent->name : ''" 
        :sub-title="isset($content->additional['subTitle']) ? $content->additional['subTitle'] : ''"
    />

    @if ($content->content && count($content->content) > 0)
        @foreach ($content->content as $section)
        <x-section :section="$section"/>
        @endforeach
    @endif

    @php
    $accId = 'acc-'.Str::uuid();
    @endphp

    <div @class(['content-section','pt-0'])>
        <div class="container">
            <div class="accordion vstack gap-3" id="{{$accId }}">
                @foreach ($content->contents as $key => $item)
                <div class="accordion-item bg-white rounded shadow-none border">
                    <h2 class="accordion-header h4">
                        <button class="accordion-button rounded fw-semibold bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-collapse-{{$item->id}}" aria-expanded="true" aria-controls="acc-collapse-{{$item->id}}">
                            {!! $item->name !!}
                        </button>
                    </h2>
                    <div id="acc-collapse-{{$item->id}}" class="accordion-collapse collapse" data-bs-parent="#{{$accId }}">
                    <div class="accordion-body pt-0">
                        {!! $item->summary !!}
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

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