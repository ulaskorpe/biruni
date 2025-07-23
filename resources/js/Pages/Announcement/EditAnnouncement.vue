<template>
    
    <div>
        <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="visible = true"/>

        <Dialog @hide="hide" v-model:visible="visible" modal header="İçerik Tipi Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update" class="d-flex flex-column h-100">

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
                                <img :src="`/dmn/media/flags/${props.announcement.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ props.announcement.language }}</span>
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
                                <img :src="`/dmn/media/flags/${props.announcement.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ props.announcement.language }}</span>
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
                <button type="button" class="btn btn-light ms-5" @click="cancel()">Vazgeç</button>
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
import Textarea from "primevue/textarea";
import InputSwitch from 'primevue/inputswitch';
import Divider from 'primevue/divider';
import Button from "primevue/button";
import InputMask from 'primevue/inputmask';

const props = defineProps({
    announcement:Object,
    onHide:{
        type:Function,
        default:() => {}
    }
});

const visible = ref(true);

const form = useForm({
    users_only:props.announcement.users_only,
    name:props.announcement.name,
    description:props.announcement.description,
    start_date:"",
    end_date:"",
});

const cancel = () => {
    visible.value = false;
    form.reset();
};

const hide = () => {
    visible.value = false;
    props.onHide();
}

const update = () => {

    form.put(route('announcements.update',[props.announcement,{language:props.announcement.language}]),{
        preserveScroll: true,
        onSuccess: (page) => {
            visible.value = false;
        }
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
    form.start_date = formatDateToMask(props.announcement.start_date);
    form.end_date = formatDateToMask(props.announcement.end_date);
});

</script>