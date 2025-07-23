@php
    
    $display = true;

    if( $isMobile && !$container['settings']['display']['mobile'] ){
        $display = false;
    }

    if( !$isMobile && !$container['settings']['display']['desktop'] ){
        $display = false;
    }

    $classes = [
        'container' => !$container['settings']['fullWidth'],
        'container-fluid' => $container['settings']['fullWidth'],
        'large-container' => isset($container['settings']['largeContainer']) && $container['settings']['largeContainer'],
        'position-relative',
    ];

    if($container['settings']['class']) $classes[] = $container['settings']['class'];
    foreach ($container['settings']['margin'] as $key => $value) {
        if($value) $classes[] = $value;
    }
    foreach ($container['settings']['padding'] as $key => $value) {
        if($value) $classes[] = $value;
    }

    if(isset($container['settings']['rounded'])) $classes[] = $container['settings']['rounded'];

    $containerId = $isLayout ? 'container_'.Str::uuid() : $container['settings']['id'];

@endphp

@if ( $display )

<div @class($classes) id="{{$containerId}}">

    @if ($container['settings']['background']['color'])
    <div @class(['overlay',$container['settings']['background']['color'],$container['settings']['rounded']])></div>
    @endif

    @if ($container['settings']['background']['image'])
    <div @class(['overlay',$container['settings']['background']['size'],$container['settings']['background']['position'],$container['settings']['rounded']]) data-bg-image="{{$container['settings']['background']['image']}}"></div>
    @endif

    @if ($container['settings']['background']['layer']['color'])
    <div @class(['overlay',$container['settings']['background']['layer']['color'],$container['settings']['background']['layer']['opacity'],$container['settings']['rounded']])></div>
    @endif

    @if (count($container['rows']) > 0)
        
    @foreach ($container['rows'] as $row)
    <x-row :row="$row" :content="$content"/>
    @endforeach

    @endif

</div>

@endif