<x-fe-layout :header-layout="$content->header_layout" :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">

    <div class="content-section hero-section text-primary">
        <div class="container">
            <div class="row justify-content-center g-0">
                <div class="col-xl-8">

                    <div class="vstack gap-2">

                        <h1 class="h3 fw-bold mb-0">{{$content->name}}</h1>

                        @if ($content->summary)
                        {!! $content->summary !!}
                        @endif

                    </div>

                </div>

                @if ($content->main_image->count() > 0)
                <div class="col-xl-10">
                    <img src="{{$content->main_image[0]->original_url}}" class="img-fluid rounded-4 mt-4 mx-auto" width="{{$content->main_image[0]->custom_properties['width']}}" height="{{$content->main_image[0]->custom_properties['height']}}" alt="{{$content->name}}">
                </div>
                @endif

                <div class="col-xl-8 blog-page mt-5">
                    {!! $content->description !!}
                </div>
                
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