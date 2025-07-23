<form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
    @csrf
        @honeypot
    <div class="form-floating mb-3">
        <input type="text" class="form-control bg-light" name="name" value="{{old('name')}}" autocomplete="username" required id="register-name" placeholder="Adınız Soyadınız"/>
        <label for="register-name">Adınız Soyadınız</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control bg-light" name="email" value="{{old('email')}}" autocomplete="username" required id="register-email" placeholder="{{ __('E-Posta Adresiniz') }}"/>
        <label for="register-email">E-Posta</label>
    </div>
    <div class="form-floating mb-4">
        <input type="password" class="form-control bg-light" name="password" value="" required autocomplete="current-password" id="register-password" placeholder="Şifre"/>
        <label for="register-password">Şifre</label>
    </div>
    <div class="form-floating mb-4">
        <input type="password" class="form-control bg-light" name="password_confirmation" value="" required autocomplete="current-password" id="register-password-confirm" placeholder="Şifre tekrar"/>
        <label for="register-password-confirm">Şifre tekrar</label>
    </div>

    <button class="btn btn-success px-4" type="submit">Gönder</button>

    @if ($errors->get('email') || $errors->get('password'))
        <div class="alert alert-danger mt-4 mb-0 p-2">
            <ul class="mb-0 list-unstyled">
                @foreach ($errors->all() as $error)
                <li><small>{{ $error }}</small></li>
                @endforeach
            </ul>
        </div>
    @endif
</form>