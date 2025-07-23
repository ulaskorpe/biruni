<div>
    <form class="needs-validation" novalidate method="post" action="{{ route('adres.update',$adres) }}">
        @csrf
        @honeypot
        @method('PUT')

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Adres Adı</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" class="form-control form-control-lg" name="title" value="{{old('title',$adres->title)}}" autocomplete="title" required/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Alıcı Adı Soyadı</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" class="form-control form-control-lg name-input" name="name" value="{{old('name',$adres->name)}}" autocomplete="name" required/>
                <div class="invalid-feedback">{{ __('Ad soyad alanı en az 2 kelime olmalıdır.') }}</div>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">E-Posta</label>
            <div class="col-md-8 col-lg-9">
                <input type="email" class="form-control form-control-lg" name="email" value="{{old('email', $adres->email)}}" autocomplete="email" required/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Telefon</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" class="form-control form-control-lg" name="phone" value="{{old('phone', $adres->phone)}}" autocomplete="phone" required/>
            </div>
        </div>

        @php
            $guid = Str::uuid();
        @endphp

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Ülke</label>
            <div class="col-md-8 col-lg-9">
                <x-country-select :guid="$guid" :countryId="$adres->country_id"/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Şehir</label>
            <div class="col-md-8 col-lg-9">
                <x-state-select :guid="$guid" :countryId="$adres->country_id" :stateId="$adres->state_id"/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 mb-3 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">İlçe</label>
            <div class="col-md-8 col-lg-9">
                <x-city-select :guid="$guid" :countryId="$adres->country_id" :stateId="$adres->state_id" :cityId="$adres->city_id"/>
            </div>
        </div>

        <div class="row g-3 g-xl-4 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder">Adres</label>
            <div class="col-md-8 col-lg-9">
                <textarea class="form-control form-control-lg" name="address" required>{{old('address',$adres->address)}}</textarea>
            </div>
        </div>

        <hr class="my-4">

        <div class="row g-3 g-xl-4 align-items-center">
            <label class="col-md-4 col-lg-3 fw-bolder"></label>
            <div class="col-md-8 col-lg-9">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="use-for-billing-{{$adres->id}}" name="use_for_billing" onchange="useForBilling(this);" @checked(old('use_for_billing', $adres->use_for_billing))>
                    <label class="form-check-label" for="use-for-billing-{{$adres->id}}">Bu adresi fatura bilgilerimde de kullan</label>
                </div>
            </div>
        </div>
        
        <div @class(['for-billing' => $adres->use_for_billing,'for-billing d-none' => !$adres->use_for_billing])>
            <hr class="my-4">
            <div class="row g-3 g-xl-4 mb-3 align-items-center">
                <label class="col-md-4 col-lg-3 fw-bolder">Fatura Tipi</label>
                <div class="col-md-8 col-lg-9">
                    <div class="for-billing-type">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="billing_type" id="bireyselFatura-{{$adres->id}}" onchange="billingType(this);" value="Bireysel" {{ $adres->use_for_billing ? 'required' : '' }} {{ $adres->billing_type == 'Bireysel' ? ' checked' : '' }}>
                            <label class="form-check-label" for="bireyselFatura-{{$adres->id}}">Bireysel</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="billing_type" id="kurumsalFatura-{{$adres->id}}" onchange="billingType(this);" value="Kurumsal" {{ $adres->use_for_billing ? 'required' : '' }} {{ $adres->billing_type == 'Kurumsal' ? ' checked' : '' }}>
                            <label class="form-check-label" for="kurumsalFatura-{{$adres->id}}">Kurumsal</label>
                        </div>
                    </div>
                </div>
            </div>

            <div @class([
                'row g-3 g-xl-4 align-items-center billing-details-bireysel' => $adres->billing_type == 'Bireysel',
                'row g-3 g-xl-4 align-items-center d-none billing-details-bireysel' => $adres->billing_type != 'Bireysel'
                ])
            >
                <label class="col-md-4 col-lg-3 fw-bolder">TC Kimlik Numarası</label>
                <div class="col-md-8 col-lg-9">
                    <input type="number" class="form-control form-control-lg" name="tc_no" value="{{old('tc_no',$adres->tc_no)}}" {{$adres->billing_type == 'Bireysel' ? 'required' : ''}} autocomplete="tc_no"/>
                    <div class="invalid-feedback">{{ __('TC Kimlik numarası 11 haneli olmalıdır.') }}</div>
                </div>

            </div>
            <div @class([
                'row g-3 g-xl-4 align-items-center billing-details-kurumsal' => $adres->billing_type == 'Kurumsal',
                'row g-3 g-xl-4 align-items-center d-none billing-details-kurumsal' => $adres->billing_type != 'Kurumsal'
                ])
            >

                <div class="col-12">
                    <div class="row g-3 g-xl-4 mb-3 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder">Firma Adı</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="company_name" value="{{old('company_name',$adres->company_name)}}" {{$adres->billing_type == 'Kurumsal' ? 'required' : ''}} autocomplete="company_name"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 mb-3 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder">Vergi Dairesi</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="vd" value="{{old('vd',$adres->vd)}}" {{$adres->billing_type == 'Kurumsal' ? 'required' : ''}} autocomplete="vd"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 mb-3 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder">Vergi no</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="vkn" value="{{old('vkn',$adres->vkn)}}" {{$adres->billing_type == 'Kurumsal' ? 'required' : ''}} autocomplete="vkn"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 align-items-center">
                        <label class="col-md-4 col-lg-3 fw-bolder"></label>
                        <div class="col-md-8 col-lg-9">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="e-fatura-mukellef-{{$adres->id}}" name="e_fatura" @checked(old('e_fatura', $adres->e_fatura))>
                                <label class="form-check-label" for="e-fatura-mukellef-{{$adres->id}}">E-fatura mükellefiyim</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row g-3 g-xl-4 align-items-center justify-content-end">
            <div class="col-md-8 col-lg-9">
                <button class="btn btn-info btn-lg" type="submit">Güncelle</button>
            </div>
        </div>

    </form>
</div>

