@if ($option['option_type'] == 'select')
    @php
        $filtered = Arr::first($option['values'], function ($value, $key) use($option) {
            return $value['id'] === $option['value'];
        });
    @endphp
    @if ($filtered)
    <span class="p-responsive text-black"><b>{{ $filtered['name'] }}</b></span>
    @endif
@endif

@if ($option['option_type'] == 'multiselect')
    @php
        $filtered = Arr::where($option['values'], function ($value, $key) use($option) {
            return in_array($value['id'], $option['value']);
        });
        $selected = [];
        foreach ($filtered as $val) {
            $selected[] = $val['name'];
        }
    @endphp
    <span class="p-responsive">{{ implode(', ',$selected) }}</span>
@endif

@if ($option['option_type'] == 'time')
    <dl class="row mb-0">
        <dt class="col-md-3">{{$option['name']}}</dt>
        <dd class="col-md-9 mb-0">{{ \Carbon\Carbon::parse($option['value'])->format('H:i') }}</dd>
    </dl>
@endif

@if ($option['option_type'] == 'date')
    <dl class="row mb-0">
        <dt class="col-md-3">{{$option['name']}}</dt>
        <dd class="col-md-9 mb-0">{{ \Carbon\Carbon::parse($option['value'])->format('d.m.Y') }}</dd>
    </dl>
@endif

@if ($option['option_type'] == 'vimeo' && $option['value'] != '')
<div class="ratio ratio-16x9 rounded overflow-hidden mb-3">
    <iframe src="https://player.vimeo.com/video/{{$option['value']}}" title="Vimeo video" allowfullscreen></iframe>
</div>
@endif

@if (in_array($option['option_type'],['textarea','input']))
    <dl class="row mb-0">
        <dt class="col-md-3">{{$option['name']}}</dt>
        <dd class="col-md-9 mb-0">{{ $option['value'] }}</dd>
    </dl>
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