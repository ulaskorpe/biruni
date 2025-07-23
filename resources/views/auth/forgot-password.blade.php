<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">
    
    <div class="mt-5">
        <x-page-header :headerVideo="null"  :title="__('Şifre Yenileme')" :headerImage="null"/>
    </div>

    <div class="container">
        <div class="">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-6">
                    <x-forgot-password-form />
                </div>
                <div class="col-lg-6 bg-dark rounded">
                    <div class="d-flex flex-column h-100 justify-content-center p-3 p-xl-5">
                        @if ($settings->logo['main'])
                        <img class="img-fluid" src="{{ $settings->logo['main']['original_url'] }}" width="{{ $settings->logo['main']['custom_properties']['width'] }}" height="{{ $settings->logo['main']['custom_properties']['height'] }}"/>
                        @else
                        <span>{{ $settings->site_name }}</span>
                        @endif
                        <p class="mt-4 text-white p-responsive">
                            Sanat ve deneyim yolculuğunuza Masterpiece ile başlayın! Ücretsiz üye olarak, özel içeriklere erişim sağlayabilir, atölye ve kurslarımıza indirimli kayıt olabilir ve Masterpiece dünyasındaki yeniliklerden haberdar olabilirsiniz.
                            <br><br>
                            Yaratıcı dünyamızın bir parçası olmak için hızlı ve kolay şekilde üye olun!
                        </p>
                        <div>
                            <a href="{{route('register')}}" class="btn btn-light">Yeni Üyelik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-fe-layout>
