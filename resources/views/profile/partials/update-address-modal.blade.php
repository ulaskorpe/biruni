<form class="modal fade needs-validation" novalidate id="update-address-modal" tabindex="-1" aria-hidden="true" method="post" action="{{ route('adres.update',$adres) }}">
    @csrf
        @honeypot
    @method('PUT')
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">Adres Güncelle</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="row g-3 g-xl-4 mb-3">
                    <div class="col-lg-6">
                        <label>Adres Adı</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$adres->title)}}" autocomplete="name" required/>
                    </div>
                    <div class="col-lg-6">
                        <label>Alıcı Adı Soyadı</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$adres->name)}}" autocomplete="name" required/>
                    </div>
                    <div class="col-lg-6">
                        <label>E-Posta</label>
                        <input type="email" class="form-control" name="email" value="{{old('email', $adres->email)}}" autocomplete="email" required/>
                    </div>
                    <div class="col-lg-6">
                        <label>Telefon</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone', $adres->phone)}}" autocomplete="phone" required/>
                    </div>
                    <div class="col-lg-4">
                        <label>Ülke</label>
                        <select class="form-control p-0 country-select" name="country_id" required data-states="state-select-{{$adres->id}}" data-selected="{{$adres->country_id}}"></select>
                    </div>
                    <div class="col-lg-4">
                        <label>Şehir</label>
                        <select class="form-control state-select" name="state_id" required id="state-select-{{$adres->id}}" data-cities="city-select-{{$adres->id}}" data-selected="{{$adres->state_id}}" data-selected-name="{{ $adres->state->name }}"></select>
                    </div>
                    <div class="col-lg-4">
                        <label>İlçe</label>
                        <select class="form-control city-select" name="city_id" required id="city-select-{{$adres->id}}" data-selected="{{$adres->city_id}}" data-selected-name="{{ $adres->city->name }}"></select>
                    </div>
                    <div class="col-lg-12">
                        <label>Adres</label>
                        <textarea class="form-control" name="address" required>{{old('address',$adres->address)}}</textarea>
                    </div>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="use-for-billing" name="use_for_billing" onchange="useForBilling(this);" @checked(old('use_for_billing', $adres->use_for_billing))>
                    <label class="form-check-label" for="use-for-billing">Bu adresi fatura bilgilerimde de kullan</label>
                </div>
                <div id="for-billing" class="d-none">
                    <div class="row g-3 g-xl-4 mb-3">
                        <div class="col-lg-12">
                            <label class="fw-bold">Fatura Tipi</label>
                            <div id="for-billing-type">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="billing_type" id="bireyselFatura" onchange="billingType(this);" value="Bireysel" required @checked(old('billing_type', $adres->billing_type))>
                                    <label class="form-check-label" for="bireyselFatura">Bireysel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="billing_type" id="kurumsalFatura" onchange="billingType(this);" value="Kurumsal" required @checked(old('billing_type', $adres->billing_type))>
                                    <label class="form-check-label" for="kurumsalFatura">Kurumsal</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 mb-3 d-none" id="billing-details-bireysel">
                        <div class="col-lg-12">
                            <label class="fw-bold">TC Kimlik Numarası</label>
                            <input type="number" class="form-control" name="tc_no" value="{{old('tc_no',$adres->tc_no)}}" autocomplete="tc_no"/>
                        </div>
                    </div>
                    <div class="row g-3 g-xl-4 mb-3 d-none" id="billing-details-kurumsal">
                        <div class="col-lg-12">
                            <label class="fw-bold">Firma Adı</label>
                            <input type="text" class="form-control" name="company_name" value="{{old('company_name',$adres->company_name)}}" autocomplete="company_name"/>
                        </div>
                        <div class="col-lg-12">
                            <label class="fw-bold">Vergi Dairesi</label>
                            <input type="text" class="form-control" name="vd" value="{{old('vd',$adres->vd)}}" autocomplete="vd"/>
                        </div>
                        <div class="col-lg-6">
                            <label class="fw-bold">Vergi no</label>
                            <input type="text" class="form-control" name="vkn" value="{{old('vkn',$adres->vkn)}}" autocomplete="vkn"/>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="e-fatura-mukellef" name="e_fatura" @checked(old('e_fatura', $adres->e_fatura))>
                                <label class="form-check-label" for="e-fatura-mukellef">E-fatura mükellefiyim</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit">Güncelle</button>
            </div>
        </div>
    </div>

</form>