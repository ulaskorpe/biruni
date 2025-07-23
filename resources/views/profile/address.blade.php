<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">
    
    <x-page-header :headerVideo="null"  title="Hesabım" :headerImage="null"/>

    <div class="container">

        @include('profile.partials.profile-menu')

        <div class="bg-light p-3 p-xl-4 rounded">
            <div class="d-flex flex-row align-items-center justify-content-between mb-4">
                <h2 class="lead-responsive mb-0">Adreslerim</h2>
                <button type="button" class="btn btn-success btn-sm" data-address-title="Yeni Adres Ekle" onclick="addNewAdress(this)">Yeni Ekle</button>
            </div>
            <div class="row g-3 g-xl-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
                @foreach ($addresses as $item)
                <div class="col">
                    <div class="card bg-white">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-row align-items-center justify-content-between mb-3">
                                <h3 class="p-responsive mb-0">{{$item->title}}</h3>
                                <div class="d-flex flex-row">
                                    <button type="button" class="btn btn-link text-info p-0" onclick="updateAddress(this)" data-address-title="{{$item->title}}" data-address-id="{{$item->id}}"><i class="bi bi-pen"></i></button>
                                    <form method="post" action="{{route('adres.destroy',$item)}}" class="ms-2">
                                        @csrf
        @honeypot
                                        @method('DELETE')
                                        <a href="#" class="text-danger delete-record" data-bs-toggle="tooltip" title="Sil"><i class="bi bi-trash"></i></a>
                                    </form>
                                </div>
                            </div>
                            <small>{{$item->address}}</small>
                            <small class="fw-bold">{{$item->city->name ?? ''}} {{Str::replace(' Province','',$item->state->name).' '.$item->country->native}}</small>
                            <hr />
                            <small>{{$item->name}}</small>
                            <small>{{$item->email}}</small>
                            <small>{{$item->phone}}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</x-fe-layout>
