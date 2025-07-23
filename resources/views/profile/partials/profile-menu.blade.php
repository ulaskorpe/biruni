<ul class="nav d-flex flex-row flex-nowrap gap-1 mb-0 position-static overflow-auto w-100 py-1 mb-5">
    <li class="nav-item" role="presentation">
        <a type="button" href="{{route('profile.index')}}" @class([
            'btn px-3 rounded-pill btn-light text-nowrap fw-semibold',
            'active' => request()->url() == route('profile.index')
        ])>Üyelere Özel</a>
    </li>
    <li class="nav-item" role="presentation">
        <a type="button" href="{{route('profile.account')}}" @class([
            'btn px-3 rounded-pill btn-light text-nowrap fw-semibold',
            'active' => request()->url() == route('profile.account')
        ])>Hesap Bilgilerim</a>
    </li>
    <li class="nav-item" role="presentation">
        <a type="button" href="{{route('adres.index')}}" @class([
            'btn px-3 rounded-pill btn-light text-nowrap fw-semibold',
            'active' => request()->url() == route('adres.index')
        ])>Adreslerim</a>
    </li>
</ul>