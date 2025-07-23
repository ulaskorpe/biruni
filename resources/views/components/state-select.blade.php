@props([
    'countryId' => null,
    'stateId' => null,
])

@php
    if( !$countryId ){
        $turkiye = \App\Models\Country::select('id','name')->where('phonecode',90)->first();
        $countryId = $turkiye->id;
    }
    $states = \App\Models\State::where('country_id',$countryId)->orderBy('name')->get();

@endphp

<select name="state_id" id="states-{{$guid}}" class="form-control form-control-lg" required onchange="stateSelected('{{$guid}}')">
    <option value="">Lütfen Seçiniz</option>
    @if ($states)
    @foreach ($states as $state)
    <option value="{{$state->id}}" @selected($state->id == $stateId)>{{Str::replace(' Province','',$state->name)}}</option>
    @endforeach
    @endif

</select>