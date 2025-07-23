@if ($option['option_type'] == 'time')
    <div class="hstack gap3">
        <span>{{$option['name']}}</span>
        <div class="vr-rule"></div>
        <span>{{ \Carbon\Carbon::parse($option['value'])->format('H:i') }}</span>
    </div>
@endif

@if ($option['option_type'] == 'vimeo')
    <div class="d-flex flex-column">
        <a href="{{$option['value']}}" data-fancybox class="btn btn-primary"><i class="bi bi-vimeo me-2"></i> İzle</a>
    </div>
@endif

@if (in_array($option['option_type'],['textarea','input','select']))
    <div class="d-flex flex-column">
        <span>{{ $option['value'] }}</span>
    </div>
@endif

@if ($option['option_type'] == 'file')
    <a href="{{$option['value']}}" target="_blank" class="btn btn-primary d-block">{{ $option['name'] }}</a>
@endif

@if ($option['option_type'] == 'image')
    <img src="{{$option['value']}}" class="img-fluid rounded" loading="lazy"/>
@endif

@if ($option['option_type'] == 'team')
    @php
        $team = App\Models\Team::find($option['value']);
    @endphp
    <span class="lead-responsive fw-bold"><i class="bi bi-geo-alt me-2"></i>{{$team ? $team->name : ''}}</span>
@endif