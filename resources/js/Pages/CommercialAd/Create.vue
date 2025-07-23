<template>
    
    <div>
        <button type="button" :class="props.buttonClass" @click="dialogVisible = true" v-html="props.buttonText"></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Reklam Ekle">
            <form @submit.prevent="create">

                <div class="d-flex flex-row align-items-end">
                    <div class="symbol symbol-100px">
                        <img :src="form.mainImage.preview_url" v-if="form.mainImage"/>
                        <div class="symbol-label" v-else>
                            <i class="bi bi-person fs-2x"></i>
                        </div>
                    </div>
                    <div class="ms-3 d-flex flex-row align-items-center">
                        <PopupMediaLibrary :on-select="setMainImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                        <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.mainImage" @click="form.mainImage = null">Kaldır</button>
                    </div>
                </div>

                <Divider/>

                <div class="rounded p-5 bg-light border mb-5">
                    <div class="row align-items-center">
                        <label class="col-md-3 fw-bold text-uppercase">Reklam Alanı</label>
                        <div class="col-md-9">
                            <Dropdown filter v-model="form.commercial_ad_area_id" :options="props.commercialAdAreas" optionLabel="name" optionValue="id" class="w-100" />
                        </div>
                    </div>
                    <div class="row align-items-center mt-5">
                        <label class="col-md-3 fw-bold text-uppercase">İsim</label>
                        <div class="col-md-9">
                            <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors['name']}"/>
                        </div>
                    </div>
                    <div class="row align-items-center mt-5">
                        <label class="col-12 fw-bold text-uppercase">Link</label>
                        <div class="col-12">
                            <Textarea autoResize rows="1" cols="30" class="w-100" v-model="form.link" :class="{'p-invalid':form.errors['seo.description']}" />
                        </div>
                    </div>
                    <div class="row align-items-center mt-5">
                        <label class="col-md-3 fw-bold text-uppercase">Başlangıç Tarihi</label>
                        <div class="col-md-9">
                            <Calendar v-model="form.start_at" showTime hourFormat="24" :class="{'p-invalid':form.errors.start_at}"/>
                        </div>
                    </div>
                    <div class="row align-items-center mt-5">
                        <label class="col-md-3 fw-bold text-uppercase">Bitiş Tarihi</label>
                        <div class="col-md-9">
                            <Calendar v-model="form.end_at" showTime hourFormat="24" :class="{'p-invalid':form.errors.end_at}"/>
                        </div>
                    </div>
                </div>

                <FormErrors :form="form"/>

                <Divider />

                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>

            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import Divider from "primevue/divider";
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";
import Textarea from "primevue/textarea";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";

const props = defineProps({
    commercialAdAreas:{
        type:Object,
        default:[]
    },
    language:{
        type:String,
        default:'tr'
    },
    buttonClass:{
        type:String,
        default:'btn fw-bold btn-sm btn-success d-flex align-items-center'
    },
    buttonText:{
        type:String,
        default:'<i class="bi bi-person-plus fs-4"></i><span class="ms-1 lh-1">YENİ</span>'
    },
});

const dialogVisible = ref(false);

const form = useForm({
    name:"",
    language:props.language,
    commercial_ad_area_id:null,
    mainImage:null,
    link:"",
    start_at: new Date(),
    end_at: new Date(),
});

const setMainImage = (media) => {
    form.mainImage = media;
}

const create = () => {
    form.post(route('commercial-ads.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

</script>
