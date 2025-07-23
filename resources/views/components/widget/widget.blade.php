@switch($widget['type'])

    @case('slider')
        <x-widget.slider :slider="$widget['data']" />
    @break
    
    @case('menu')
        <x-widget.menu :menu="$widget['data']" />
    @break

    @case('content_categories')
        <x-widget.content-categories :widget="$widget" />
    @break

    @case('contents')
        <x-widget.contents :widget="$widget" />
    @break

    @case('design_template')
        <x-widget.design-template :data="$widget['data']" :content="$content"/>
    @break

    @case('form')
        <x-widget.form :data="$widget['data']" />
    @break

    @case('newsletter_form')
        <x-newsletter-form :data="$widget['data']" />
    @break

    @case('social_accounts')
        <x-widget.social-accounts :data="$widget['data']" />
    @break

    @case('commercial_ads')
        <x-widget.commercial-ads :widget="$widget" />
    @break

    @case('swiper_navigation')
        <x-widget.swiper-navigation :data="$widget['data']" />
    @break

    @default
        
@endswitch