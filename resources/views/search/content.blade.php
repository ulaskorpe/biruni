<x-fe-layout :bread-crumb="['data' => [],'title' => $queryParam ?? $settings->site_name]">

    <x-page-header :headerVideo="null"  :title="__('Arama sonuçları:').' '.$queryParam" :headerImage="null" :parentTitle="''"/>

    <section class="content-section">
        <div class="container">

            <div class="mb-4">
                <form class="d-flex flex-grow-1 mx-auto needs-validation" novalidate method="GET" action="{{route('search.content')}}">
                    <div class="input-group overflow-hidden border bg-light">
                        <span class="input-group-text border-0 outline-0 bg-opacity-10 bg-light"><i class="bi bi-search"></i></span>
                        <input type="hidden" name="language" value="{{app()->getLocale()}}">
                        <input name="search" value="{{$queryParam}}" type="text" class="form-control bg-opacity-10 bg-light border-0 outline-0 ps-0 shadow-none ms-0" placeholder="{{__('Arama...')}}" aria-label="Ara..." required>
                    </div>
                </form>
            </div>

            @if (Str::length($queryParam) < 3)
            <div class="alert alert-danger">
                {{ __('Lütfen en az 3 harf giriniz.') }}
            </div>
            @endif

            @if ($searchResults && $searchResults->count() === 0)
            <div class="alert alert-danger">
                {{ __('Aramanıza uygun kayıt bulunamadı.') }}
            </div>
            @endif

            @if ($searchResults)
            <div class="vstack gap-4">
                @foreach($searchResults->groupByType() as $type => $modelSearchResults)

                    @if ($type == 'contents')
                    <div>
                        <h2 class="h5 mb-4 title-style-five fw-bold">Genel İçerikler</h2>
                        <ul class="list-unstyled with-icon d-flex flex-column gap-2">
                            @foreach ($modelSearchResults as $item)
                            <li>
                                <i class="bi bi-link-45deg"></i>
                                <a href="{{ $item->url }}" class="list-group-item list-group-item-action vstack">
                                    <span class=" fw-semibold">{{ $item->searchable->seo_data->title ?? $item->title}}</span>
                                    <small>{{ $item->searchable->seo_data->description }}</small>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                @endforeach
            </div>
            @endif
            
        </div>
    </section>

    <x-slot name="headerScripts">
        
    </x-slot>

    <x-slot name="footerScripts">
        
    </x-slot>

</x-fe-layout>