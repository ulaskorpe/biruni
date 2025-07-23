<template>
    <Head head-key="title" title="Yeni Üye Ekle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    <span class="d-flex align-items-center">Yeni Üye Ekle</span>
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('users.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <form @submit.prevent="create">

                <div class="card mb-4 mb-xl-10">
                    <div class="card-body">
                        <div class="row g-5">
                            <div class="col-12">
                                <label class="form-label">Avatar</label>
                                <div class="d-flex flex-row align-items-end">
                                    <div class="symbol symbol-100px">
                                        <img :src="form.avatar_preview_url" v-if="form.avatar_preview_url"/>
                                        <div class="symbol-label" v-else>
                                            <i class="bi bi-person fs-2x"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3 d-flex flex-row align-items-center">
                                        <PopupMediaLibrary :on-select="setAvatar" :button-text="'Seç'" :mime-type="'image/'" :multiple="false" :key="'popup-library-1'"/>
                                        <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.avatar_preview_url" @click="form.avatar_preview_url = ''">Kaldır</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex flex-column">
                                <label class="form-label">Ad Soyad</label>
                                <span class="p-input-icon-left">
                                    <i class="bi bi-person" />
                                    <InputText v-model="form.name" class="w-100" />
                                </span>
                            </div>
                            <div class="col-lg-6 d-flex flex-column">
                                <label class="form-label">Email</label>
                                <span class="p-input-icon-left">
                                    <i class="bi bi-envelope" />
                                    <InputText v-model="form.email" type="email" class="w-100"/>
                                </span>
                            </div>
                            <div class="col-lg-6 d-flex flex-column">
                                <label class="form-label">Şifre</label>
                                <Password v-model="form.password" toggleMask inputClass="w-100"/>
                            </div>
                            <div class="col-lg-6 d-flex flex-column">
                                <label class="form-label">Şifre tekrar</label>
                                <Password v-model="form.password_confirmation" toggleMask :feedback="false" inputClass="w-100"/>
                            </div>
                            <div class="col-lg-12 d-flex flex-column">
                                <label class="form-label">Roller</label>
                                <MultiSelect v-model="form.roles" :options="props.roles" optionLabel="view_name" optionValue="id" placeholder="Lütfen seçiniz" :maxSelectedLabels="5" class="w-100" />
                            </div>
                            <div class="col-lg-12 d-flex flex-column">
                                <label class="form-label">Üye Tipi</label>
                                <Dropdown v-model="form.user_type" :options="userTypes" optionLabel="label" optionValue="value" placeholder="Lütfen seçiniz" class="w-100" />
                            </div>
                            <div class="col-lg-12 d-flex flex-column">
                                <label class="form-label">Kısa Tanıtım</label>
                                <TextEditor v-model="form.summary" :full-mode="false"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                    </div>
                </div>

                <FormErrors :form="form"/>

            </form>
        </div>
    </div>
    
</template>

<script setup>

import { useForm } from "@inertiajs/vue3";
import MultiSelect from 'primevue/multiselect';
import Dropdown from "primevue/dropdown";
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

import TextEditor from "../../Components/TextEditor";


const props = defineProps({
    roles:Array
});

const userTypes = [
    {
        label:"Yönetici",
        value:"admin"
    },
    {
        label:"Üye",
        value:"member"
    }
];

const form = useForm({
    name:"",
    email:"",
    password:"",
    password_confirmation:"",
    avatar:"",
    avatar_preview_url:"",
    summary:"",
    roles:[],
    user_type:"member"
});


const create = () => {
    form.post(route('users.store'),{
        onSuccess: () => {},
    });
}

const setAvatar = (media) => {

    form.avatar = media.original_url;
    form.avatar_preview_url = media.preview_url;

}

</script>