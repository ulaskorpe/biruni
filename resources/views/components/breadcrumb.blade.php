@if (!is_null($data))
<nav aria-label="breadcrumb" class="px-0 rounded-0">
    <ol class="breadcrumb m-0 p-0 bg-transparent justify-content-center flex-nowrap overflow-x-auto">
        <li class="breadcrumb-item d-flex"><a href="{{config('app-ea.app_url')}}"> <i class="bi bi-house text-light"></i> <span class="visually-hidden">Ana Sayfa</span> </a></li>
        @foreach ($data as $item)
        <li class="breadcrumb-item d-flex"><a href="{{$item['url']}}" class="link-light link-underline-opacity-0 text-nowrap">{{$item['title']}}</a></li>
        @endforeach
        <li class="breadcrumb-item d-flex active" aria-current="page"><span class="text-light text-nowrap">{{$title}}</span></li>
    </ol>
</nav>
@endif