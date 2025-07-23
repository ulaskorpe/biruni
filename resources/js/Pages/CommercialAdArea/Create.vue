<template>
    
    <div>
        <button type="button" :class="props.buttonClass" @click="dialogVisible = true" v-html="props.buttonText"></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Reklam Grubu Ekle">
            <form @submit.prevent="create">

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
const props = defineProps({
    fromAttribute:{
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
    name:props.fromAttribute ? props.fromAttribute.name : "",
});

const create = () => {
    form.post(route('commercial-ad-areas.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

</script>
