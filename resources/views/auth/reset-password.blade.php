<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">
    
    <div class="mt-5">
        <x-page-header :headerVideo="null"  :title="__('Yeni şifrenizi oluşturun')" :headerImage="null"/>
    </div>

    <div class="container">
        <div class="">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('password.store') }}" class="needs-validation" novalidate>
                        @csrf
        @honeypot
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control bg-light" name="email" value="{{old('email',$request->email)}}" autocomplete="username" required id="forgot-email" placeholder="E-posta"/>
                            <label for="forgot-email">E-Posta</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control bg-light" name="password" value="" required id="forgot-password" placeholder="Yeni Şifreniz"/>
                            <label for="forgot-password">Yeni Şifreniz</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control bg-light" name="password_confirmation" value="" required id="forgot-password-confirm" placeholder="Yeni Şifreniz"/>
                            <label for="forgot-password-confirm">Yeni Şifreniz Tekrar</label>
                        </div>
                        <button class="btn btn-success px-4" type="submit">Gönder</button>
                        @if ($errors->get('email'))
                            <div class="alert alert-danger mt-4 mb-0 p-2">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                    <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="col-lg-6 bg-dark rounded">
                    <div class="d-flex flex-column h-100 justify-content-center p-3 p-xl-5">
                        @if ($settings->logo['main'])
                        <img class="img-fluid" src="{{ $settings->logo['main']['original_url'] }}" width="{{ $settings->logo['main']['custom_properties']['width'] }}" height="{{ $settings->logo['main']['custom_properties']['height'] }}"/>
                        @else
                        <span>{{ $settings->site_name }}</span>
                        @endif
                        <p class="mt-4 text-white p-responsive">
                            Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla placerat ullamcorper ex, vel tempus justo rutrum eget. Aliquam eu ante nisl. Cras bibendum porta tellus ac vestibulum. Nunc gravida felis massa, eu egestas augue cursus at.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-fe-layout>