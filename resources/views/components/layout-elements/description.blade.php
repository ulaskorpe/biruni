<div @class(getBaseAndAnimClasses($element['data']))>
    {!! Str::replace('DESCRIPTION', $description, $element['data']['elemHtml']) !!}
</div>