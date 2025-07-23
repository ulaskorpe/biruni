@props([
    'countryId' => null,
    'stateId' => null,
    'cityId' => null,
])

@php
    
    if( !$countryId ){
        $turkiye = \App\Models\Country::select('id','name')->where('phonecode',90)->first();
        $countryId = $turkiye->id;
    }

    $states = \App\Models\State::where('country_id',$countryId)->orderBy('name')->get();

    $cities = null;

    if( $stateId ){
        $cities = \App\Models\City::where('state_id',$stateId)->orderBy('name')->get();
    }

@endphp

<select name="city_id" id="cities-{{$guid}}" class="form-control form-control-lg">
    <option value="">Lütfen Seçiniz</option>
    @if ($cities)
    @foreach ($cities as $city)
    <option value="{{$city->id}}" @selected($city->id == $cityId)>{{$city->name}}</option>
    @endforeach
    @endif

</select>