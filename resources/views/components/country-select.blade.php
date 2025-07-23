@props([
    'countryId' => null
])

@php
    $countries = \App\Models\Country::orderBy('native','ASC')->get();
@endphp

<select name="country_id" id="countries-{{$guid}}" class="form-control form-control-lg" required onchange="countrySelected('{{$guid}}')">
    <option value="">Lütfen Seçiniz</option>
    @foreach ($countries as $country)
    <option value="{{$country->id}}" @selected($countryId ? $country->id == $countryId : $country->phonecode == 90)>{{$country->native}}</option>
    @endforeach

</select>