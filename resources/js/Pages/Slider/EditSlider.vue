<template>
    
    <div>

        <Dialog v-model:visible="dialogVisible" modal @hide="props.onUpdateDone" header="Ürün Tipi Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update">

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

const props = defineProps({
    selectedSlider:Object,
    onUpdateDone:{
        type:Function,
        required:true
    }
});


const dialogVisible = ref(true);

const form = useForm({
    name:props.selectedSlider.name,
    is_fullscreen:props.selectedSlider.is_fullscreen,
    height:props.selectedSlider.height,
});

const cancel = () => {
    form.reset();
    props.onUpdateDone();
};

const update = () => {
    form.put(route('sliders.update',props.selectedSlider),{
        onSuccess: () => {
            form.reset();
            props.onUpdateDone();
        },
    });
}

</script>