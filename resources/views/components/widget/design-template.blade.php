@php
    
    //dd($data);

    $template = \App\Models\DesignTemplate::find($data['design_template']['id']);

    $elemDivClasses = ['design-template'];

    if( $template ){

        if($data['baseDesignOptions']['class']) $elemDivClasses[] = $data['baseDesignOptions']['class'];
        if(isset($data['baseDesignOptions']['position'])) $elemDivClasses[] = $data['baseDesignOptions']['position'];

        foreach ($data['baseDesignOptions']['margin'] as $key => $value) {
            if($value) $elemDivClasses[] = $value;
        }
        foreach ($data['baseDesignOptions']['padding'] as $key => $value) {
            if($value) $elemDivClasses[] = $value;
        }
        
    }

@endphp

@if ($template)
<div @class($elemDivClasses)>

    @if ($template->content)

        @if ($template->use_containers && isset($template->content[0]['containers']))

            @foreach ($template->content[0]['containers'] as $container)
            <x-container :container="$container" :content="$content" :is-layout="true"/>
            @endforeach

        @elseif ($template->use_rows && isset($template->content[0]['containers'][0]['rows']))

            @foreach ($template->content[0]['containers'][0]['rows'] as $row)
            <x-row :row="$row" :content="$content" :is-layout="true"/>
            @endforeach

        @elseif ($template->use_columns && isset($template->content[0]['containers'][0]['rows'][0]['columns']))

            @foreach ($template->content[0]['containers'][0]['rows'][0]['columns'] as $column)
            <x-column :column="$column" :content="$content" :is-layout="true"/>
            @endforeach

        @elseif ($template->content[0]['containers'][0]['rows'][0]['columns'][0]['elements'])

            @foreach ($template->content[0]['containers'][0]['rows'][0]['columns'][0]['elements'] as $element)
            @if (isset($element['widget']) && $element['widget'])
                <x-widget.widget :widget="$element" :content="$content" />
            @elseif (isset($element['render_blade']) && $element['render_blade'])
                <x-elements.index :element="$element" :content="$content" />
            @else
                {!! Str::replace('<p><br></p>','',$element['data']['elemHtml']) !!}
            @endif
            @endforeach

        @endif

    @endif

</div>
@endif