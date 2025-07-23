@if ($sections && !empty($sections))
@foreach ($sections[0]['containers'] as $container)
<x-container :container="$container" />
@endforeach
@endif