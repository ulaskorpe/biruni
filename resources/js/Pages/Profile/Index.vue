<template>
    <Head head-key="title" title="Site Ayarları" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Profil Bilgilerim
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">

            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <form @submit.prevent="update">

                <div class="card mb-4 mb-xl-10">

                    <div class="card-header">
                        <h3 class="card-title">Genel Bilgiler</h3>
                    </div>
                    <div class="card-body">

                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Ad Soyad</label>
                            <div class="col-lg-8">
                                <InputText v-model="form.name" class="w-100" disabled/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Email</label>
                            <div class="col-lg-8">
                                <InputText v-model="form.email" class="w-100" type="email" />
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Telefon</label>
                            <div class="col-lg-8">
                                <InputText v-model="form.phone" class="w-100" />
                            </div>
                        </div>

                        <FormErrors :form="form"/>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Güncelle</button>
                    </div>

                </div>

            </form>

            <form @submit.prevent="updatePassword">

                <div class="card mb-4 mb-xl-10">

                    <div class="card-header">
                        <h3 class="card-title">Şifre Değişikliği</h3>
                    </div>
                    <div class="card-body">

                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Mevcut Şifreniz</label>
                            <div class="col-lg-8">
                                <div class="d-flex flex-column">
                                    <Password v-model="passwordForm.current_password" toggleMask :feedback="false" inputClass="w-100"/>
                                </div>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Yeni Şifreniz</label>
                            <div class="col-lg-8">
                                <div class="d-flex flex-column">
                                    <Password v-model="passwordForm.password" inputClass="w-100" toggleMask/>
                                </div>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Yeni Şifreniz Tekrar</label>
                            <div class="col-lg-8">
                                <div class="d-flex flex-column">
                                    <Password v-model="passwordForm.password_confirmation" inputClass="w-100" toggleMask :feedback="false"/>
                                </div>
                            </div>
                        </div>

                        <FormErrors :form="passwordForm"/>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': passwordForm.processing }" :disabled="passwordForm.processing">Güncelle</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</template>

<script setup>

import {ref} from "vue";
import {useForm,usePage} from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Divider from "primevue/divider";
import Password from 'primevue/password';


const form = useForm({
    name:usePage().props.auth.user.name,
    email:usePage().props.auth.user.email,
    phone:usePage().props.auth.user.phone
});

const update = () => {
    form.put(route('my.index'),{
        onSuccess: () => {
            
        },
    });
}

const passwordForm = useForm({
    current_password:'',
    password:'',
    password_confirmation:''
});

const updatePassword = () => {
    passwordForm.post(route('my.updatepassword'), {
        preserveScroll: true,
        onBefore: () => {
            
        },
        onSuccess: () => {
            passwordForm.reset();
        },
    });
};

</script>