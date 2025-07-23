<template>
    <Head head-key="title" title="Header Layout Ekle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Yeni Header Layout
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('header-layouts.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <FormErrors :form="form"/>

            <form @submit.prevent="create">

                <div class="card mb-4 mb-xl-10">
                    <div class="card-body">

                        <h5 class="card-title text-muted">Genel Bilgiler</h5>
                        <Divider class="mb-10"/>

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">İsim</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors.name}"/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">Desktop Logo</label>
                            <div class="col-md-9">
                                <div class="d-flex flex-row align-items-end">
                                    <div class="bg-light p-3 me-3" v-if="form.json_data.logo.main">
                                        <img :src="form.json_data.logo.main.original_url"/>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <PopupMediaLibrary :on-select="setMainLogo" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                        <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.json_data.logo.main" @click="form.json_data.logo.main = null">Kaldır</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">Mobile Logo</label>
                            <div class="col-md-9">
                                <div class="d-flex flex-row align-items-end">
                                    <div class="bg-light p-3 me-3" v-if="form.json_data.logo.mobile">
                                        <img :src="form.json_data.logo.mobile.original_url"/>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <PopupMediaLibrary :on-select="setMobileLogo" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                        <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.json_data.logo.mobile" @click="form.json_data.logo.mobile = null">Kaldır</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">BG CLASS</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.json_data.backgroundClass"/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">LINK COLOR CLASS</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.json_data.linkColorClass"/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">BUTTON #1 CLASS</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.json_data.headerButtonOneClass"/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">BUTTON #2 CLASS</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.json_data.headerButtonTwoClass"/>
                            </div>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty">Kaydet</button>

            </form>
        </div>
    </div>

    
</template>

<script setup>

import { useForm } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

const form = useForm({
    name:"",
    json_data:{
        logo:{
            main:null,
            mobile:null,
        },
        backgroundClass:"",
        linkColorClass:"",
        headerButtonOneClass:"",
        headerButtonTwoClass:""
    },
    content:[],
});

const create = () => {
    form.post(route('header-layouts.store'),{
        onSuccess: () => {
            
        },
    });
}

const setMainLogo = (media) => {
    form.json_data.logo.main = media;
}
const setMobileLogo = (media) => {
    form.json_data.logo.mobile = media;
}

</script>