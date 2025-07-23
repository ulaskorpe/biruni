@php
    $navbarClasses = 'navbar navbar-expand cs-navbar py-0';
    $linkClasses = 'nav-link';
    $buttonOneClass = 'btn-primary';
    $buttonTwoClass = 'btn-secondary';
    $logo = isset($settings->logo['main']) ? $settings->logo['main'] : null;
    $logoMobile = isset($settings->logo['mobile']) ? $settings->logo['mobile'] : null;

    if( $headerLayout ){

        if( isset($headerLayout['json_data']['backgroundClass']) && !empty($headerLayout['json_data']['backgroundClass']) ){
            $navbarClasses = 'navbar navbar-expand cs-navbar py-0 '.$headerLayout['json_data']['backgroundClass'];
        }

        if( isset($headerLayout['json_data']['linkColorClass']) && !empty($headerLayout['json_data']['linkColorClass']) ){
            $linkClasses = 'nav-link '.$headerLayout['json_data']['linkColorClass'];
        }

        if( isset($headerLayout['json_data']['headerButtonOneClass']) && !empty($headerLayout['json_data']['headerButtonOneClass']) ){
            $buttonOneClass = $headerLayout['json_data']['headerButtonOneClass'];
        }

        if( isset($headerLayout['json_data']['headerButtonTwoClass']) && !empty($headerLayout['json_data']['headerButtonTwoClass']) ){
            $buttonTwoClass = $headerLayout['json_data']['headerButtonTwoClass'];
        }

        if( isset($headerLayout['json_data']['logo']['main']) && !empty($headerLayout['json_data']['logo']['main']) ){
            $logo = $headerLayout['json_data']['logo']['main'];
        }

        if( isset($headerLayout['json_data']['logo']['mobile']) && !empty($headerLayout['json_data']['logo']['mobile']) ){
            $logoMobile = $headerLayout['json_data']['logo']['mobile'];
        }

    }

    $logoLink = '/';
    if( app()->getLocale() != config('languages.default') ){
        $logoLink = '/'.app()->getLocale();
    }

@endphp


@if ($isMobile)

    <header @class([$navbarClasses]) id="main-mobile-navbar">
        
        <div class="container pe-2" aria-label="Top Navigation">

            <a href="{{$logoLink}}" class="me-3">
                @if ($logoMobile)
                <img class="logo" src="{{ $logoMobile['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $logoMobile['custom_properties']['width'] }}" height="{{ $logoMobile['custom_properties']['height'] }}">
                @elseif ($logo)
                <img class="logo" src="{{ $logo['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $logo['custom_properties']['width'] }}" height="{{ $logo['custom_properties']['height'] }}">
                @else
                <span>{{ $settings->site_name }}</span>
                @endif
            </a>

            <div class="d-flex ms-auto align-items-center">
                <button class="btn text-primary p-0 align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#csNavbar" aria-controls="csNavbar" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="bi" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                </button>
            </div>

        </div>

    </header>

@else

    <div class="bg-primary py-2 position-relative zindex-3 d-none d-xl-block">

        <div class="container d-flex align-items-center justify-content-between">
            <a class="d-flex align-items-center gap-1 text-white text-decoration-none" href="https://wa.me/{{ Str::replace(['+',' '],['',''],$settings->contact['whatsapp']) }}" target="_blank">
                <img src="/media/2025/5/3/whatsapp.svg" alt="Whatsapp" width="34" height="34">
                <div class="d-flex flex-column lh-sm">
                    <span class="opacity-40 fs-xs">WHATSAPP</span>
                    <span class="fw-bolder">{{ $settings->contact['whatsapp'] }}</span>
                </div>
            </a>
            <div class="fs-sm text-white text-center">
                Location permission needed for a better experience.
            </div>
            <div class="d-flex align-items-center gap-3">
                @foreach ($settings->socials as $key => $item)
                <a href="{{$item['value']}}" @class(['text-white text-hover-light'])  target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$item['key']}}">
                    <i class="bi bi-{{$item['key']}} fs-6"></i>
                </a>
                @endforeach
            </div>
        </div>

    </div>

    <header @class([$navbarClasses]) id="main-navbar">
        
        
        <div class="container d-flex align-items-center justify-content-start" aria-label="Top Navigation">

            <a href="{{$logoLink}}" class="me-4">
                @if ($logo)
                <img class="logo" src="{{ $logo['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $logo['custom_properties']['width'] }}" height="{{ $logo['custom_properties']['height'] }}">
                @else
                <span>{{ $settings->site_name }}</span>
                @endif
            </a>

            <nav class="d-flex align-items-center" aria-label="Main navigation">
                @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['main']))
    
                    <div class="d-flex d-xl-none align-items-center">
                        <button class="btn text-dark text-hover-primary p-0 border-0 hstack gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#csNavbar" aria-controls="csNavbar" aria-label="Toggle navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" class="bi" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                            </svg>
                            <span>MENÜ</span>
                        </button>
                    </div>
    
                    <ul class="navbar-nav d-none d-xl-flex flex-row flex-nowrap align-items-center">
                        @foreach (session()->get('core_menus')['data'][app()->getLocale()]['main']['items'] as $item)
                        @if (count($item['child_nodes']) > 0)
                        <li @class(['nav-item dropdown','ktm-mega-menu'=> $item['megamenu']])>
                            <a href="#" @class([$linkClasses,'dropdown-toggle']) data-bs-toggle="dropdown" aria-expanded="false">{!! $item['menu_title'] !!}</a>
                            @if ($item['megamenu'])
                            <div class="dropdown-menu mega-menu animate__animated animate__faster" data-animation="animate__fadeInUp">
                                <div class="bg-white pt-3 pb-5 min-h-500px border-bottom">
                                    <nav class="container large-container">
                                        <ul class="row row-cols-2 row-cols-lg-4 row-cols-xl-5 g-4 list-unstyled ps-0">
                                            @foreach ($item['child_nodes'] as $sub)
                                            <li class="col pt-3">
                                                <a class="vstack gap-2 text-decoration-none link-dark" href="{{$sub['item_link']}}">
                                                    @if ($sub['image'])
                                                    <div class="overflow-hidden h-150px hover-image-scale">
                                                        <img loading="lazy" src="{{ $sub['image'] }}" alt="{{ $sub['menu_title'] }}" class="w-100 h-100 object-fit-cover">
                                                    </div>
                                                    @endif
                                                    <span class="title-style-five fw-bold text-uppercase">{!! $sub['menu_title'] !!}</span>
                                                    @if (isset($sub['item_desc']) && !empty($sub['item_desc']))
                                                    <small class="text-primary">{{$sub['item_desc']}}</small>
                                                    @endif
                                                </a>
                                                @if ($sub['child_nodes'])
                                                <ul class="list-unstyled mt-2 mb-0 vstack gap-2">
                                                    @foreach ($sub['child_nodes'] as $third)
                                                    <li>
                                                        <a href="{{ $third['item_link'] }}" class="link-dark link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{!! $third['menu_title'] !!}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            @else
                            <ul class="dropdown-menu animate__animated animate__faster animate__fadeInUp">
                                @foreach ($item['child_nodes'] as $sub)
                                <li>
                                    <a href="{{$sub['item_link']}}" class="dropdown-item">{!! $sub['menu_title'] !!}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{$item['item_link']}}" @class([$linkClasses])>{!! $item['menu_title'] !!}</a>
                        </li>
                        @endif
        
                        @endforeach
        
                    </ul>
    
                @endif
    
            </nav>

            <div class="hstack gap-3 ms-auto">   
                @if (isset($settings->header_buttons[app()->getLocale()]))
                <div class="hstack align-items-center gap-2">
                    @if ($settings->header_buttons[app()->getLocale()]['button_1']['active'])
                    <a href="{{$settings->header_buttons[app()->getLocale()]['button_1']['button_link']}}" @class(['btn btn-sm px-3 h-40px d-flex text-nowrap align-items-center fw-semibold',$buttonOneClass]) @if ($settings->header_buttons[app()->getLocale()]['button_1']['new_window']) target="_blank" @endif>
                        {!! $settings->header_buttons[app()->getLocale()]['button_1']['button_text'] !!}
                    </a>
                    @endif
                    @if ($settings->header_buttons[app()->getLocale()]['button_2']['active'])
                    <a href="{{$settings->header_buttons[app()->getLocale()]['button_2']['button_link']}}" @class(['btn btn-sm px-3 h-40px d-flex text-nowrap align-items-center fw-semibold',$buttonTwoClass]) @if ($settings->header_buttons[app()->getLocale()]['button_2']['new_window']) target="_blank" @endif>
                        {!! $settings->header_buttons[app()->getLocale()]['button_2']['button_text'] !!}
                    </a>
                    @endif
                </div>
                @endif
            </div>

            @if (config('languages.language_bar'))
            <div class="d-none d-xl-block ms-3 rounded bg-opacity-75 bg-dark px-3 py-2">
                <x-switch-language />
            </div>
            @endif

        </div>

    </header>

@endif

{{-- offcanvas ekran boyutuna gore desktop icin de kullanılabilir. --}}

<div @class(['offcanvas offcanvas-end']) tabindex="-1" id="csNavbar" data-bs-scroll="false">
    <div class="offcanvas-header px-3 py-3">
        @if ($logo)
        <img class="mw-75" src="{{ $logo['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $logo['custom_properties']['width'] }}" height="{{ $logo['custom_properties']['height'] }}">
        @endif
        <button type="button" class="btn text-primary p-0 border-0 shadow-none bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#csNavbar"><i class="bi bi-x-lg fs-3"></i></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">

        @if (session()->has('core_menus') && isset(session()->get('core_menus')['data'][app()->getLocale()]['main']))
        <nav>
            <ul class="list-unstyled d-flex flex-column gap-3">
                @foreach (session()->get('core_menus')['data'][app()->getLocale()]['main']['items'] as $item)
                <li>
                    <a href="{{$item['item_link']}}" @class(['main-level link-dark text-decoration-none'])>{!! $item['menu_title'] !!}</a>
                    @if (count($item['child_nodes']) > 0)
                    <ul class="list-unstyled d-flex flex-column gap-1 mb-2 mt-1">
                        @foreach ($item['child_nodes'] as $sub)
                        <li>
                            <a href="{{$sub['item_link']}}" class="text-primary text-decoration-none fw-semibold">{!! $sub['menu_title'] !!}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </nav>
        @endif

        @if (config('languages.language_bar'))
      
            <x-switch-language />
      
        @endif

        <div>
        @if (isset($settings->header_buttons[app()->getLocale()]))
            <div class="vstack gap-2 mt-4">
                @if ($settings->header_buttons[app()->getLocale()]['button_1']['active'])
                <a href="{{$settings->header_buttons[app()->getLocale()]['button_1']['button_link']}}" @class(['btn btn-sm p-3 d-flex align-items-center justify-content-center fw-bolder text-uppercase h-40px',$buttonOneClass]) @if ($settings->header_buttons[app()->getLocale()]['button_1']['new_window']) target="_blank" @endif>
                    {!! $settings->header_buttons[app()->getLocale()]['button_1']['button_text'] !!}
                </a>
                @endif
                @if ($settings->header_buttons[app()->getLocale()]['button_2']['active'])
                <a href="{{$settings->header_buttons[app()->getLocale()]['button_2']['button_link']}}" @class(['btn btn-sm p-3 d-flex align-items-center justify-content-center fw-bolder text-uppercase h-40px',$buttonTwoClass]) @if ($settings->header_buttons[app()->getLocale()]['button_2']['new_window']) target="_blank" @endif>
                    {!! $settings->header_buttons[app()->getLocale()]['button_2']['button_text'] !!}
                </a>
                @endif

            </div>
        @endif
        </div>

    </div>
</div>