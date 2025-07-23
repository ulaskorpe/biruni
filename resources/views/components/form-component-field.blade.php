@props(['formId' => '','item' => []])

@php
    $name = isset($item['itemInputName']) ? $item['itemInputName'] : Str::slug($item['itemLabel'],'_');
@endphp

<div class="{{ $item['size'] }}">

    @if (in_array($item['type'],['text','number','email','password']))
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <input type="{{$item['type']}}" class="form-control" name="{{$name}}" id="{{$formId.'-'.$name}}" value="{{old($name)}}"  placeholder="{{ $item['itemLabel'] }}" @if($item['required']) required @endif/>
    </div>
    @endif

    @if ($item['type'] == 'range')
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2 d-flex align-items-end gap-3">
            <span>{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</span>
            <span class="range-value bg-primary text-white px-2 py-1 rounded fw-bold">{{$item['rangeOptions']['default']}}</span>
        </label>
        <input oninput="this.closest('div').querySelector('.range-value').innerText = this.value" type="range" name="{{$name}}" class="form-range" min="{{$item['rangeOptions']['min']}}" max="{{$item['rangeOptions']['max']}}" step="{{$item['rangeOptions']['step']}}" id="{{$formId.'-'.$name}}" value="{{$item['rangeOptions']['default']}}">
    </div>
    @endif

    @if ($item['type'] == 'intTelInput')
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <input type="text" class="form-control int-tel-input" name="{{$name}}" id="{{$formId.'-'.$name}}" value="{{old($name)}}" @if($item['required']) required @endif/>
    </div>
    @endif

    @if ($item['type'] == 'textarea')
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <textarea class="form-control" name="{{$name}}" id="{{$formId.'-'.$name}}"  placeholder="{{ $item['itemLabel'] }}" @if($item['required']) required @endif>{{old($name)}}</textarea>
    </div>
    @endif

    @if ($item['type'] == 'checkbox')
    <div class="d-flex flex-column">
        <label class="form-label">{{ $item['itemLabel'] }}</label>
        <div class="d-flex flex-column gap-1 checkbox-group">
            @foreach ($item['options'] as $key => $option)
            <div class="form-check">
                <input onchange="checkboxRequiredCheck(this)" class="form-check-input" type="checkbox" value="{{ $option }}" name="{{$name}}[]" id="{{$formId.'-'.$name.'-'.$key}}" @if($item['required']) required @endif>
                <label class="form-check-label" for="{{$formId.'-'.$name.'-'.$key}}">{{ $option }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if ($item['type'] == 'radio')
    <div class="d-flex flex-column">
        <label class="form-label">{{ $item['itemLabel'] }}</label>
        <div class="d-flex flex-column gap-1 checkbox-group">
            @foreach ($item['options'] as $key => $option)
            <div class="form-check">
                <input class="form-check-input" type="radio" value="{{ $option }}" name="{{$name}}" id="{{$formId.'-'.$name.'-'.$key}}" @if($item['required']) required @endif>
                <label class="form-check-label" for="{{$formId.'-'.$name.'-'.$key}}">{{ $option }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if ($item['type'] == 'radioWithIcon')
    <div class="d-flex flex-column align-items-center">
        <label class="form-label mb-3">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <div class="d-flex gap-2 justify-content-center checkbox-group flex-wrap">
            @foreach ($item['optionsWithIcon'] as $key => $option)
            <div class="h-100">
                <input class="btn-check icon-check" type="radio" value="{{ $option['value'] }}" name="{{$name}}" id="{{$formId.'-'.$name.'-'.$key}}" @if($item['required']) required @endif>
                <label class="btn btn-outline-light h-100" for="{{$formId.'-'.$name.'-'.$key}}">
                    <div class="d-flex flex-column gap-2 text-primary">
                        <i class="bi bi-circle fs-6"></i>
                        <i class="bi bi-check-circle fs-6"></i>
                        {!! $option['icon'] !!}
                        @if ($option['text'])
                        <span class="fs-xs">{{ $option['value'] }}</span>
                        @endif
                    </div>
                </label>
                @if ($loop->last)
                <span class="invalid-feedback position-absolute start-0 end-0 text-center pt-1">{{ __('Lütfen seçiniz') }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if ($item['type'] == 'select')
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <select class="form-select" name="{{$name}}" id="{{$formId.'-'.$name}}"  placeholder="{{ $item['itemLabel'] }}" @if($item['required']) required @endif>
            <option value="">Lütfen Seçiniz</option>
            @foreach ($item['options'] as $option)
            <option value="{{$option}}">{{$option}}</option>
            @endforeach
        </select>
    </div>
    @endif

    @if ($item['type'] == 'stateSelect')
    @php
        $states = \App\Models\State::select('id','name')->where('country_id',225)->orderBy('name')->get();
    @endphp
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <select onchange="stateSelectedByName('{{$randomFormGuid}}')" id="states-{{$randomFormGuid}}" class="form-select" name="{{$name}}" placeholder="{{ $item['itemLabel'] }}" @if($item['required']) required @endif>
            <option value="">Lütfen Seçiniz</option>
            @foreach ($states as $state)
            <option value="{{Str::replace(' Province','',$state->name)}}" data-state-id="{{$state->id}}">{{Str::replace(' Province','',$state->name)}}</option>
            @endforeach
        </select>
    </div>
    @endif

    @if ($item['type'] == 'citySelect')
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <select id="cities-{{$randomFormGuid}}" class="form-select" name="{{$name}}" placeholder="{{ $item['itemLabel'] }}" @if($item['required']) required @endif>
            <option value="">Lütfen öncelikle şehir seçiniz</option>
        </select>
    </div>
    @endif

    @if ($item['type'] == 'contentList')
    @php
        $selectContents = \App\Models\Content::select('id','name')->whereIn('content_type_id',$item['contentTypes'])->orderBy('content_type_id')->get();
    @endphp
    <div class="">
        <label for="{{$formId.'-'.$name}}" class="form-label ps-2">{{ $item['itemLabel'] }}{!! $item['required'] ? ' <span class="text-danger">*</span>' : '' !!}</label>
        <select id="{{$formId.'-'.$name}}"  class="form-select" name="{{$name}}" placeholder="{{ $item['itemLabel'] }}" @if($item['required']) required @endif>
            <option value="">{{__('Lütfen Seçiniz')}}</option>
            @foreach ($selectContents as $cont)
            <option value="{{$cont->name}}">{{$cont->name}}</option>
            @endforeach
        </select>
    </div>
    @endif

</div>