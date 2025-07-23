@php
    
    $emailId = Str::uuid();
    $passwordId = Str::uuid();

@endphp

<form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
    @csrf
        @honeypot
    <div class="form-floating mb-3">
        <input type="email" class="form-control bg-light" name="email" value="{{old('email')}}" autocomplete="username" required id="login-email-{{$emailId}}" placeholder="E-posta"/>
        <label for="login-email-{{$emailId}}">E-Posta</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control bg-light" name="password" value="" required autocomplete="current-password" id="login-password-{{$passwordId}}" placeholder="Şifre"/>
        <label for="login-password-{{$passwordId}}">Şifre</label>
    </div>
    <button class="btn btn-primary px-4" type="submit">Giriş</button>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{route('password.request')}}" class="link-primary link-offset-3 link-underline-opacity-25 link-underline-opacity-100-hover">
            <small>Şifremi Unuttum</small>
        </a>
        <a href="{{route('register')}}" class="link-primary link-offset-3 link-underline-opacity-25 link-underline-opacity-100-hover">
            <small>Yeni Üyelik</small>
        </a>
    </div>
    @if ($errors->get('email') || $errors->get('password'))
        <div class="alert alert-danger mt-4 mb-0 p-2">
            <ul class="mb-0 list-unstyled">
                @foreach ($errors->all() as $error)
                <li><small>{{ $error }}</small></li>
                @endforeach
            </ul>
        </div>
        <script>
            window.addEventListener('DOMContentLoaded',function(){
                const loginDropDown = new bootstrap.Dropdown(document.querySelector('#account-toggle-icon'));
                loginDropDown.show();
            });
        </script>
    @endif
</form>