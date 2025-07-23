@if ($contents)
    @foreach ($contents as $section)
    <x-section :section="$section" />
    @endforeach
@endif