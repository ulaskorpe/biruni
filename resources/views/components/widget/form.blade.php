@php
    
    //dd($data);

    $form = \App\Models\Form::find($data['form']['id']);

    $elemDivClasses = [];

    if( $form ){

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

@if ($form)
<div @class($elemDivClasses)>

    <x-form-component :form="$form" />

</div>
@endif