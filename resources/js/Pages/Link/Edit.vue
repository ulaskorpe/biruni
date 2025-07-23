<template>
    
    <div>
        <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="visible = true"/>

        <Dialog @hide="hide" v-model:visible="visible" modal header="Link Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update" class="d-flex flex-column h-100">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center mb-1">
                        <span class="fw-semibold">{{ props.link.linkable.name }}</span>
                        <div class="d-flex align-items-center ms-2">
                            <img :src="`/dmn/media/flags/${props.link.language}.svg`" class="me-2" style="width: 14px" />
                            <span class="text-uppercase">{{ props.link.language }}</span>
                        </div>
                    </div>
                    <InputText v-model="form.final_uri" class="w-100" />
                </div>

                <Divider />

                <div class="d-flex flex-row align-items-center">
                    <InputSwitch v-model="form.redirect_old" />
                    <label class="fw-bold ms-2">Eskisini 301 Yönlendir</label>
                </div>

                <Divider />

                <div class="">
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing || form.final_uri == props.link.final_uri }" :disabled="form.processing || form.final_uri == props.link.final_uri">Kaydet</button>
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
import Button from 'primevue/button';
import InputSwitch from 'primevue/inputswitch';
import Divider from "primevue/divider";

const props = defineProps({
    link:Object,
    onDone:{
        type:Function,
        default:() => {}
    }
});

const visible = ref(true);

const form = useForm({
    final_uri:props.link.final_uri,
    redirect_old:false
});

const cancel = () => {
    visible.value = false;
    form.reset();
};

const update = () => {
    form.put(route('links.update',props.link.id),{
        onSuccess: (page) => {
            visible.value = false;
        }
    });
}

const hide = () => {
    visible.value = false;
    props.onDone();
}


</script>