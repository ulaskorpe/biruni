<template>
    
    <div>
        <button type="button" class="btn fw-bold btn-sm btn-success d-flex align-items-center" @click="dialogVisible = true"><i class="bi bi-person-plus fs-4"></i><span class="ms-1 lh-1">EKLE</span></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Slider Ekle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="create">

                <div class="row align-items-center">
                    <label class="col-md-6 form-label">İSİM</label>
                    <div class="col-md-6">
                        <InputText v-model="form.name" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 form-label">Yükseklik</label>
                    <div class="col-md-6">
                        <InputText v-model="form.height" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="d-flex flex-row align-items-center">
                    <div class="d-flex flex-row">
                        <InputSwitch v-model="form.is_fullscreen" />
                        <label class="fw-bold ms-2">Full Screen</label>
                    </div>
                </div>

                <Divider class="my-10"/>

                <div>
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                    <button type="button" class="btn btn-light ms-5" @click="cancel()">Vazgeç</button>
                </div>

                <FormErrors :form="form"/>

            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Divider from "primevue/divider";


const dialogVisible = ref(false);

const form = useForm({
    name:"",
    is_fullscreen:false,
    height:""
});

const cancel = () => {
    dialogVisible.value = false;
    form.reset();
};


const create = () => {
    form.post(route('sliders.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

</script>