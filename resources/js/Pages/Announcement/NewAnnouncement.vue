<template>
    
    <div>
        <button type="button" :class="props.buttonClass" @click="dialogVisible = true" v-html="props.buttonText"></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Duyuru Ekle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="create">

                <div class="row g-5 align-items-center">
                    <label class="col-lg-6 fw-bold">Sadece Üyeler Görsün</label>
                    <div class="col-lg-6">
                        <InputSwitch v-model="form.users_only" />
                    </div>
                </div>

                <Divider />

                <div class="row g-5 align-items-center">
                    <label class="col-lg-6 fw-bold">
                        <div class="d-flex align-items-center mb-1">
                            <span class="fw-semibold">İsim</span>
                            <div class="d-flex align-items-center ms-2">
                                <img :src="`/dmn/media/flags/${props.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ props.language }}</span>
                            </div>
                        </div>
                    </label>
                    <div class="col-lg-6">
                        <InputText class="w-100" v-model="form.name" />
                    </div>
                </div>

                <Divider />

                <div class="row g-5 align-items-center">
                    <label class="col-lg-6 fw-bold">
                        <div class="d-flex align-items-center mb-1">
                            <span class="fw-semibold">Duyuru</span>
                            <div class="d-flex align-items-center ms-2">
                                <img :src="`/dmn/media/flags/${props.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ props.language }}</span>
                            </div>
                        </div>
                    </label>
                    <div class="col-lg-6">
                        <Textarea autoResize rows="1" cols="30" class="w-100" v-model="form.description" />
                    </div>
                </div>

                <Divider />
                
                <div class="row g-5 align-items-center">
                    <label class="col-lg-6 fw-bold">Başlangıç Tarihi</label>
                    <div class="col-lg-6">
                        <InputMask v-model="form.start_date" :class="{'p-invalid':form.errors.start_date}" mask="99.99.9999" placeholder="GG.AA.YYYY"/>
                    </div>
                </div>

                <Divider />

                <div class="row g-5 align-items-center">
                    <label class="col-lg-6 fw-bold">Bitiş Tarihi</label>
                    <div class="col-lg-6">
                        <InputMask v-model="form.end_date" :class="{'p-invalid':form.errors.start_date}" mask="99.99.9999" placeholder="GG.AA.YYYY"/>
                    </div>
                </div>

                <div class="separator my-10"></div>
                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                <FormErrors :form="form"/>

            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref, onMounted} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Divider from 'primevue/divider';
import Button from "primevue/button";
import InputMask from 'primevue/inputmask';
import Textarea from "primevue/textarea";

const props = defineProps({
    language:{
        type:String,
        default:'tr'
    },
    fromAnnouncement:{
        type:Object,
        default:null
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
    name:props.fromAnnouncement ? props.fromAnnouncement.name+' - '+props.language : "",
    language:props.language,
    description:props.fromAnnouncement ? props.fromAnnouncement.description : "",
    start_date:"",
    end_date:"",
    uuid:props.fromAnnouncement ? props.fromAnnouncement.uuid : "",
    users_only:props.fromAnnouncement ? props.fromAnnouncement.users_only : false,
});

const create = () => {

    form.post(route('announcements.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

const formatDateToMask = (date) => {
    var originalDate = new Date(date);
    var day = originalDate.getDate().toString().padStart(2, '0');
    var month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Ay 0-11 arasında olduğu için +1 ekliyoruz.
    var year = originalDate.getFullYear();

    return day + '.' + month + '.' + year;
}

onMounted(() => {
    form.start_date = props.fromAnnouncement ? formatDateToMask(props.fromAnnouncement.start_date) : "";
    form.end_date = props.fromAnnouncement ? formatDateToMask(props.fromAnnouncement.end_date) : "";
});

</script>