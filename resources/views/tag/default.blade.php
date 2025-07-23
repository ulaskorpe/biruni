<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">
    
    <x-page-header :headerVideo="null"  :title="'Etiket: '.$content->name" :headerImage="null" :parentTitle="''"/>

    @php
    
        $type = null;

        if( request()->type ){

            $type = request()->type;

        }
    
    @endphp
    
    <section class="content-section">

        @if (!$type)

            @if ($content->contents()->count() > 0)
            <div class="container">

                <ul class="list-unstyled with-icon d-flex flex-column gap-2">
                    @foreach ($content->contents as $item)
                    <li>
                        <i class="bi bi-link-45deg"></i>
                        <a href="{{ $item->uri->final_uri }}" class="list-group-item list-group-item-action fw-semibold">{{ $item->additional['customTitleText'] ?? $item->name}}</a>
                        @if ($item->summary)
                        <div class="fs-sm">{!! $item->summary !!}</div>
                        @endif
                    </li>
                    @endforeach
                </ul>

            </div>
            @endif

        @else
        
            @if ($type == 'content')
            
                @php
                    $items = $content->contents()->paginate(30)->withQueryString();
                @endphp

                <div class="container">

                    <ul class="list-unstyled with-icon d-flex flex-column gap-2">
                        @foreach ($items as $item)
                        <li>
                            <i class="bi bi-link-45deg"></i>
                            <a href="{{ $item->uri->final_uri }}" class="text-reset link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{{ $item->additional['customTitleText'] ?? $item->name}}</a>
                        </li>
                        @endforeach
                    </ul>

                </div>
                
            @endif

        @endif

    </section>


</x-fe-layout>