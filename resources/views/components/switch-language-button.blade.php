
@props([
    'href' => "",
    'language' => config('languages.default')
])

<a href="{{ $href }}" class="dropdown-item p-1" title="{{ languageName($language) }}">
    <img src="{{ asset('images/flags/' . $language . '.svg') }}" alt="{{ $language }}" width="24" height="24">
</a>
