<template>
    
    <div>
        <Dialog @hide="hide" v-model:visible="visible" modal header="Reklam Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update" class="d-flex flex-column h-100">

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

                <div class="">
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                    <button type="button" class="btn btn-light ms-5" @click="cancel()">Vazgeç</button>
                </div>

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
    item:Object,
    commercialAdAreas:{
        type:Object,
        default:[]
    },
    onHide:{
        type:Function,
        default:() => {}
    }
});

const visible = ref(true);

const form = useForm({
    name:props.item.name,
    language:props.item.language,
    commercial_ad_area_id:props.item.commercial_ad_area_id,
    mainImage:props.item.main_image,
    link:props.item.link,
    start_at: props.item.start_at ? new Date(props.item.start_at) : new Date(),
    end_at: props.item.end_at ? new Date(props.item.end_at) : new Date(),
});

const cancel = () => {
    visible.value = false;
    form.reset();
};

const setMainImage = (media) => {
    form.mainImage = media;
}

const update = () => {
    form.put(route('commercial-ads.update',[props.item,{language:props.item.language}]),{
        preserveScroll: true,
        onSuccess: (page) => {
            visible.value = false;
        }
    });
}

const hide = () => {
    visible.value = false;
    props.onHide();
}


</script>