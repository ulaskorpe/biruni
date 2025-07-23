@props([
    'connecteds' => [],
    'settings' => null
])

@php
    $currentLang = app()->getLocale();
@endphp

<div x-data="{ open: false }" class="relative inline-block">
    <!-- Düğme (transparent arkaplanlı) -->
<a href="#" @click.prevent="open = !open"
        class="inline-flex items-center gap-2 px-2 py-1 rounded-md bg-transparent text-white hover:bg-transparent focus:outline-none"
        type="button" aria-haspopup="true" :aria-expanded="open.toString()">

        <img src="{{ asset('images/flags/' . $currentLang . '.svg') }}" alt="{{ $currentLang }}" width="20" height="20" class="rounded-sm">

        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
        </svg>
    </a>

    <!-- Dropdown Menü -->
    <div x-show="open" x-transition.opacity @click.away="open = false"
        class="absolute right-0 mt-2 w-12 z-50">

            <div class="flex flex-col items-center bg-transparent py-2 space-y-2 mt-2">
            @foreach (config('languages.active') as $lang)
                @php
                    $lang_exists = Arr::first($connecteds, fn ($value) => $value['language'] === $lang);

                    if ($lang_exists) {
                        if ($lang_exists->uuid == $settings->home_page) {
                            $url = ($lang_exists['language'] == config('languages.default'))
                                ? config('app.url')
                                : config('app.url') . '/' . $lang;
                        } else {
                            $url = $lang_exists['uri']['final_uri'];
                        }
                    } else {
                        $url = ($lang == config('languages.default'))
                            ? config('app.url')
                            : config('app.url') . '/' . $lang;
                    }
                @endphp
<div style="width: 100%;margin-bottom:10px">
<a href="{{ $url }}" @click="open = false"
class="hover:scale-110 transition-transform inline-flex items-center gap-2 px-2 py-1 pt-2 rounded-md bg-transparent mt-2 flex">
                    <img src="{{ asset('images/flags/' . $lang . '.svg') }}"
                         alt="{{ $lang }}"
                         class="w-6 h-6 rounded-sm">
                        </a>
                    </div>

            @endforeach
        </div>
    </div>
</div>
