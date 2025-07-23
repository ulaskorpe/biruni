@props([
    'element' => null
])

@if ($element && isset($element['data']['content'][0]))

@foreach ($element['data']['content'][0]['containers'][0]['rows'] as $row)
    <x-row :row="$row" :content="$content" :is-layout="true"/>
@endforeach

@endif