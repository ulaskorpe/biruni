<template>
    
    <div>
        <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="dialogVisible = true" class="ms-2"/>
        <Dialog v-model:visible="dialogVisible" modal :header="`${props.slider.name} için yeni slide ekle`" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update">

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Desktop Görsel</label>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column">
                            <div class="bg-light p-3 mb-3" v-if="form.image">
                                <img :src="form.image.original_url" class="img-fluid"/>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <PopupMediaLibrary :on-select="setImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.image" @click="form.image = null">Kaldır</button>
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Mobil Görsel</label>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column">
                            <div class="bg-light p-3 mb-3" v-if="form.mobile_image">
                                <img :src="form.mobile_image.original_url" class="img-fluid"/>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <PopupMediaLibrary :on-select="setMobileImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.mobile_image" @click="form.mobile_image = null">Kaldır</button>
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Video</label>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column">
                            <div class="bg-light p-3 mb-3" v-if="form.video">
                                <video controls class="w-100">
                                    <source :src="form.video.original_url" type="video/mp4">
                                </video>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <PopupMediaLibrary :on-select="setVideo" :button-text="'Seç'" :mime-type="'video/'" :key="Math.floor(Math.random() * 100000)"/>
                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.video" @click="form.video = null">Kaldır</button>
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Başlık</label>
                    <div class="col-lg-6">
                        <InputText v-model="form.title" class="w-100" />
                    </div>
                </div>
                
                <Divider />

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Açıklama</label>
                    <div class="col-lg-6">
                        <Textarea autoResize rows="1" cols="30" class="w-100" v-model="form.description" />
                    </div>
                </div>
                
                <Divider />

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Buton #1</label>
                    <div class="col-lg-6">
                        <div class="d-flex">
                            <InputSwitch v-model="form.json_data.buttons.button_1.active"/>
                            <span class="ms-3">Aktif</span>
                        </div>
                        <div v-if="form.json_data.buttons.button_1.active" class="mt-3">
                            <div class="mb-3">
                                <label>Buton Yazı</label>
                                <InputText v-model="form.json_data.buttons.button_1.text" class="w-100" />
                            </div>
                            <div class="">
                                <label>Buton Link</label>
                                <InputText v-model="form.json_data.buttons.button_1.link" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-lg-6 form-label">Buton #2</label>
                    <div class="col-lg-6">
                        <div class="d-flex">
                            <InputSwitch v-model="form.json_data.buttons.button_2.active"/>
                            <span class="ms-3">Aktif</span>
                        </div>
                        <div v-if="form.json_data.buttons.button_2.active" class="mt-3">
                            <div class="mb-3">
                                <label>Buton Yazı</label>
                                <InputText v-model="form.json_data.buttons.button_2.text" class="w-100" />
                            </div>
                            <div class="">
                                <label>Buton Link</label>
                                <InputText v-model="form.json_data.buttons.button_2.link" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>

                <Divider class="my-10"/>

                <div class="">
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                    <button type="button" class="btn btn-light ms-5" @click="cancel">Vazgeç</button>
                </div>

                <FormErrors :form="form"/>

            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref} from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Divider from "primevue/divider";
import Button from "primevue/button";
import Textarea from "primevue/textarea";
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

const props = defineProps({
    slider:Object,
    slide:Object,
    updateDone:{
        type:Function,
        default:() => {}
    }
});

const dialogVisible = ref(false);

const form = useForm({
    title:props.slide.title,
    slider_id:props.slider.id,
    description:props.slide.description,
    image:props.slide.image,
    mobile_image:props.slide.mobile_image,
    video:props.slide.video,
    json_data:{
        buttons:props.slide.json_data.buttons ? props.slide.json_data.buttons : {
            button_1:{
                active:false,
                text:"",
                link:"",
            },
            button_2:{
                active:false,
                text:"",
                link:"",
            }
        }
    },
});

const cancel = () => {
    dialogVisible.value = false;
    form.reset();
};

const setImage = (media) => {
    form.image = media;
}
const setMobileImage = (media) => {
    form.mobile_image = media;
}
const setVideo = (media) => {
    form.video = media;
}

const update = () => {
    form.put(route('slider-slides.update',props.slide),{
        onSuccess: () => {
            props.updateDone(usePage().props.flash.data);
            dialogVisible.value = false;
        },
    });
}

</script>