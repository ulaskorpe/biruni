<div>
    <form class="needs-validation" novalidate method="post" action="{{ route('adres.store') }}">
        @csrf
        @honeypot
        @method('POST')

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Adres Adı</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" class="form-control form-control-lg" name="title" value="{{old('title')}}" autocomplete="title" required/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Alıcı Adı Soyadı</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" class="form-control form-control-lg name-input" name="name" value="{{old('name')}}" autocomplete="name" required/>
                <div class="invalid-feedback">{{ __('Ad soyad alanı en az 2 kelime olmalıdır.') }}</div>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">E-Posta</label>
            <div class="col-md-8 col-lg-9">
                <input type="email" class="form-control form-control-lg" name="email" value="{{old('email')}}" autocomplete="email" required/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Telefon</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" class="form-control form-control-lg" name="phone" value="{{old('phone')}}" autocomplete="phone" required/>
            </div>
        </div>

        @php
            $guid = Str::uuid();
        @endphp

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Ülke</label>
            <div class="col-md-8 col-lg-9">
                <x-country-select :guid="$guid" />
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Şehir</label>
            <div class="col-md-8 col-lg-9">
                <x-state-select :guid="$guid" />
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">İlçe</label>
            <div class="col-md-8 col-lg-9">
                <x-city-select :guid="$guid" />
            </div>
        </div>

        <div class="row g-3 g-xl-4 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Adres</label>
            <div class="col-md-8 col-lg-9">
                <textarea class="form-control form-control-lg" name="address" required>{{old('address')}}</textarea>
            </div>
        </div>

        <hr class="my-4">

        <div class="row g-3 g-xl-4 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder"></label>
            <div class="col-md-8 col-lg-9">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="use-for-billing-new" name="use_for_billing" onchange="useForBilling(this);">
                    <label class="form-check-label" for="use-for-billing-new">Bu adresi fatura bilgilerimde de kullan</label>
                </div>
            </div>
        </div>
        

        <div @class(['for-billing d-none'])>
            <hr class="my-4">
            <div class="row g-3 g-xl-4 mb-3 align-items-center">
                <label class="col-md-4 col-lg-3 fw-bolder">Fatura Tipi</label>
                <div class="col-md-8 col-lg-9">
                    <div class="for-billing-type">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="billing_type" id="bireyselFatura-new" onchange="billingType(this);" value="Bireysel">
                            <label class="form-check-label" for="bireyselFatura-new">Bireysel</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="billing_type" id="kurumsalFatura-new" onchange="billingType(this);" value="Kurumsal">
                            <label class="form-check-label" for="kurumsalFatura-new">Kurumsal</label>
                        </div>
                    </div>
                </div>
            </div>

            <div @class(['row g-3 g-xl-4 align-items-center d-none billing-details-bireysel'])>
                <label class="col-md-4 col-lg-3 fw-bolder">TC Kimlik Numarası</label>
                <div class="col-md-8 col-lg-9">
                    <input type="number" class="form-control form-control-lg" name="tc_no" value="{{old('tc_no')}}" autocomplete="tc_no"/>
                    <div class="invalid-feedback">{{ __('TC Kimlik numarası 11 haneli olmalıdır.') }}</div>
                </div>
            </div>
            <div @class(['row g-3 g-xl-4 align-items-center d-none billing-details-kurumsal'])>

                <div class="col-12">
                    <div class="row g-3 g-xl-4 mb-3 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder">Firma Adı</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="company_name" value="{{old('company_name')}}" autocomplete="company_name"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 mb-3 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder">Vergi Dairesi</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="vd" value="{{old('vd')}}" autocomplete="vd"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 mb-3 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder">Vergi no</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="vkn" value="{{old('vkn')}}" autocomplete="vkn"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder"></label>
                        <div class="col-md-8 col-lg-9">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="e-fatura-mukellef-new" name="e_fatura" @checked(old('e_fatura'))>
                                <label class="form-check-label" for="e-fatura-mukellef-new">E-fatura mükellefiyim</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row g-3 g-xl-4 align-items-center justify-content-end">
            <div class="col-md-8 col-lg-9">
                <button class="btn btn-info btn-lg" type="submit">Kaydet</button>
            </div>
        </div>

    </form>
</div>