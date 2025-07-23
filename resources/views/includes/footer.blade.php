@php
    $logo = isset($settings->logo['main']) ? $settings->logo['main'] : null;
@endphp

<footer class="bg-light">

    <div class="py-5 py-xl-7 bg-primary">
        <div class="container">

            <div class="d-flex gap-5 flex-wrap flex-xl-nowrap">

                @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['footer-1']))
                <div class="d-flex flex-column order-1">
                @foreach (session()->get('core_menus')['data'][app()->getLocale()]['footer-1']['items'] as $item)
                    <div class="fw-bold mb-2 text-white">{!!$item['menu_title']!!}</div>
                    @if ($item['child_nodes'])
                    <ul class="list-unstyled mb-0">
                        @foreach ($item['child_nodes'] as $child)
                        <li>
                            <a href="{{$child['item_link']}}" class="text-light text-decoration-none fs-sm">{{$child['menu_title']}}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                @endforeach
                </div>
                @endif

                @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['footer-2']))
                <div class="d-flex flex-column flex-grow-1 order-3 order-xl-2 w-100 w-xl-auto">
                    @foreach (session()->get('core_menus')['data'][app()->getLocale()]['footer-2']['items'] as $item)
                    <div class="fw-bold mb-2 text-white">{!!$item['menu_title']!!}</div>
                    @if ($item['child_nodes'])
                    <ul class="list-unstyled mb-0 column-count-2 column-count-lg-3">
                        @foreach ($item['child_nodes'] as $child)
                        <li>
                            <a href="{{$child['item_link']}}" class="text-light text-decoration-none fs-sm">{{$child['menu_title']}}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                @endforeach
                </div>
                @endif

                @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['footer-3']))
                <div class="d-flex flex-column col-xl-auto order-2 order-xl-3">
                @foreach (session()->get('core_menus')['data'][app()->getLocale()]['footer-3']['items'] as $item)
                    <div class="fw-bold mb-2 text-white">{!!$item['menu_title']!!}</div>
                    @if ($item['child_nodes'])
                    <ul class="list-unstyled mb-0">
                        @foreach ($item['child_nodes'] as $child)
                        <li>
                            <a href="{{$child['item_link']}}" class="text-light text-decoration-none fs-sm">{{$child['menu_title']}}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                @endforeach
                </div>
                @endif

            </div>

            <hr class="border-white my-5 my-xl-6"/>

            <div class="d-flex gap-5 flex-column flex-lg-row flex-lg-nowrap">

                <div class="mw-xl-250px">
                    {!! $settings->footer_slogan[app()->getLocale()] ?? "" !!}
                </div>

                @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['footer-4']))
                <div class="d-flex flex-grow-1">
                    <ul class="list-unstyled mb-0 column-count-2 column-count-lg-3">
                        @foreach (session()->get('core_menus')['data'][app()->getLocale()]['footer-4']['items'] as $item)
                        <li>
                            <a href="{{$item['item_link']}}" class="text-light text-decoration-none fs-sm">{{$item['menu_title']}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>

        </div>
    </div>

    @if (isset($settings->footer_form[app()->getLocale()]))
    <x-footer-form :formid="$settings->footer_form[app()->getLocale()]" />
    @endif

    <div class="py-5">
        <div class="container text-center d-flex flex-column align-items-center gap-4">

            @if ($logo)
            <img loading="lazy" class="img-fluid" src="{{ $logo['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $logo['custom_properties']['width'] }}" height="{{ $logo['custom_properties']['height'] }}" />
            @endif

            <span class="text-primary fw-semibold fs-xs">
                © {{ now()->year }} {{ $settings->site_name }}
            </span>

            @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['copyright']))
            <ul @class(['nav'])>
                @foreach (session()->get('core_menus')['data'][app()->getLocale()]['copyright']['items'] as $item)
                <li class="nav-item">
                    <a href="{{$item['item_link']}}" class="nav-link fs-xs text-decoration-underline link-offset-2">{!! $item['menu_title'] !!}</a>
                </li>
                @endforeach
            </ul>
            @endif

        </div>
    </div>

</footer>