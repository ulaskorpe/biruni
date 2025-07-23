@if ($content->uri)
<a href="{{$content->uri->final_uri}}" class="w-100 h-100 content-card d-flex flex-column gap-3 text-reset text-decoration-none">
@else
<div class="w-100 h-100 content-card d-flex flex-column gap-3">
@endif

    @if ($content->main_image->count() > 0)
    <div class="overflow-hidden h-150px h-lg-200px h-xl-250px hover-image-scale rounded">
        <img loading="lazy" src="{{$content->main_image[0]->original_url}}" class="w-100 h-100 object-fit-cover" width="{{$content->main_image[0]->custom_properties['width']}}" height="{{$content->main_image[0]->custom_properties['height']}}" alt="{{$content->name}}">
    </div>
    @endif
    @if ($useDate)
        <small class="text-muted">
            <i class="bi bi-calendar me-2"></i>{{$content->start_date->format('d.m.Y')}}
        </small>
    @endif
    <h3 class="p-responsive mb-0 fw-semibold">
        {{$content->name}}
    </h3>
    {{--
    @if($content->summary)
    <p class="fs-sm mb-0">{{ Str::limit(strip_tags($content->summary),100,'...') }}</p>
    @endif
    --}}

@if ($content->uri)
</a>
@else
</div>
@endif