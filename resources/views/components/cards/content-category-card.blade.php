<a href="{{$category->uri->final_uri}}" class="text-decoration-none text-dark">
    @if ($category->main_image->count() > 0)
    <div class="overflow-hidden h-150px h-lg-200px h-xl-250px hover-image-scale mb-3">
        <img loading="lazy" src="{{$category->main_image[0]->original_url}}" class="w-100 h-100 object-fit-cover" width="{{$category->main_image[0]->custom_properties['width']}}" height="{{$category->main_image[0]->custom_properties['height']}}" alt="{{$category->name}}">
    </div>
    @endif
    <p class="title-style-five text-primary text-uppercase fw-bold mb-2">{{ $category->name }}</p>
    @if ($category->summary)
    <div class="fs-sm mb-2">
        {{ Str::limit(strip_tags($category->summary),100,'...') }}
    </div>
    @endif
</a>