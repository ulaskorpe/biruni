<section>

    <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
        @csrf
        @honeypot
        @method('patch')

        <div class="row g-3 g-xl-4">
            <div class="col-12">
                <label class="form-label">Adınız Soyadınız</label>
                <input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}" autocomplete="name" required/>
                @error('name')
                    <span class="d-block invalid-feedback">{{$message}}</span>
                @enderror
            </div>
            <div class="col-xl-6">
                <label class="form-label">E-Posta Adresi</label>
                <input type="email" class="form-control" name="email" value="{{old('email', $user->email)}}" autocomplete="email" required/>
                @error('email')
                    <span class="d-block invalid-feedback">{{$message}}</span>
                @enderror
            </div>
            <div class="col-xl-6">
                <label class="form-label">Telefon</label>
                <input type="text" class="form-control" name="phone" value="{{old('phone', $user->phone)}}" autocomplete="phone" required/>
                @error('phone')
                    <span class="d-block invalid-feedback">{{$message}}</span>
                @enderror
            </div>
        </div>

        <hr class="my-4" />

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="promotions" name="email_promotions"{{ $user->email_promotions ? ' checked' : '' }}>
            <label class="form-check-label" for="promotions">
              Kampanya ve tanıtımlar için iletişim bilgilerimin kullanılmasına izin veriyorum.
            </label>
         </div>

         <button class="btn btn-success" type="submit">Güncelle</button>

    </form>
</section>
