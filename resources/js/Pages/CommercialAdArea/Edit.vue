<template>
    
    <div>
        <Dialog @hide="hide" v-model:visible="visible" modal header="Reklam Grubu Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update" class="d-flex flex-column h-100">

                <div class="rounded p-5 bg-light border mb-5">
                    <div class="row align-items-center">
                        <label class="col-md-3 fw-bold text-uppercase">İsim</label>
                        <div class="col-md-9">
                            <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors['name']}"/>
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

const props = defineProps({
    item:Object,
    onHide:{
        type:Function,
        default:() => {}
    }
});

const visible = ref(true);

const form = useForm({
    name:props.item.name,
});

const cancel = () => {
    visible.value = false;
    form.reset();
};

const update = () => {
    form.put(route('commercial-ad-areas.update',props.item),{
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