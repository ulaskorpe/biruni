<x-fe-layout :bread-crumb="['data' => [],'title' => $queryParam ?? $settings->site_name]">

    <x-page-header :headerVideo="null"  :title="$queryParam.' için arama sonuçları'" :headerImage="null" :parentTitle="''"/>

    <section class="content-section">
        <div class="container">

            <div class="mb-4">
                <form class="d-flex flex-grow-1 mx-auto needs-validation" novalidate method="GET" action="{{route('search.content')}}">
                    <div class="input-group overflow-hidden border bg-light">
                        <span class="input-group-text border-0 outline-0 bg-opacity-10 bg-light"><i class="bi bi-search"></i></span>
                        <input name="search" value="{{$queryParam}}" type="text" class="form-control bg-opacity-10 bg-light border-0 outline-0 ps-0 shadow-none ms-0" placeholder="Arama..." aria-label="Ara..." required>
                    </div>
                </form>
            </div>
            
            @if ($searchResults)
            <ul class="list-unstyled with-icon d-flex flex-column gap-2">
                @foreach ($searchResults as $item)
                <li>
                    <i class="bi bi-link-45deg"></i>
                    <a href="{{ $item->uri->final_uri }}" class="list-group-item list-group-item-action fw-semibold">{{ $item->additional['customTitleText'] ?? $item->name}}</a>
                    @if ($item->summary)
                    <div class="fs-sm">{{$item->summary}}</div>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
            
        </div>
    </section>

    <x-slot name="headerScripts">
        
    </x-slot>

    <x-slot name="footerScripts">
        
    </x-slot>

</x-fe-layout>