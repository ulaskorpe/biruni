<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">
    
    <x-page-header :headerVideo="null"  title="Hesabım" :headerImage="null"/>

    <div class="container">

        @include('profile.partials.profile-menu')

        <div class="bg-light p-3 p-xl-4 rounded">
            <h2 class="lead-responsive mb-4">Hesap Bilgilerim</h2>
            @include('profile.partials.update-profile-form')
        </div>
    </div>

</x-fe-layout>
