<x-fe-layout :bread-crumb="['data' => $content->uri->breadcrumb ?? [],'title' => $content->name]">
    
    <x-page-header :headerVideo="null"  :title="Auth::user()->name" :headerImage="null"/>

    <div class="container">

        @include('profile.partials.profile-menu')

    </div>

</x-fe-layout>
