@php
    $showLayout = false;
    if( $element['data']['categories'] || $element['data']['tags'] || $element['data']['author'] || $element['data']['date'] ){
        $showLayout = true;
    }


@endphp

@if ($showLayout)
<div @class(getBaseAndAnimClasses($element['data']))>

    @if ($element['data']['categories'] && $content->content_categories->count() > 0)
        <div class="hstack gap-2 my-1">
            <i class="bi bi-bookmarks-fill text-primary" data-bs-toggle="tooltip" title="{{__('Kategoriler')}}"></i>
            <div>
                @foreach ($content->content_categories as $category)
                <a href="{{$category->uri->final_uri}}" class="fs-sm text-reset link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{{ $category->name }}</a>{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </div>
        </div>
    @endif

    @if ($element['data']['tags'] && $content->tags->count() > 0)
        <div class="hstack gap-2 my-1">
            <i class="bi bi-tags-fill text-primary" data-bs-toggle="tooltip" title="{{__('Etiketler')}}"></i>
            <div>
                @foreach ($content->tags as $tag)
                <a href="{{$tag->uri->final_uri}}" class="fs-sm text-reset link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{{ $tag->name }}</a>{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </div>
        </div>
    @endif

</div>
@endif