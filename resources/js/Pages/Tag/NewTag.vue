<template>
    
    <div>
        <button type="button" :class="props.buttonClass" @click="dialogVisible = true" v-html="props.buttonText"></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Etiket Ekle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="create">

                <div>

                    <div class="d-flex flex-column">
                        <label class="form-label">İSİM <span class="badge badge-dark p-2 ms-2 text-uppercase">{{ curr_language }}</span></label>
                        <InputText v-model="form.name" class="w-100" />
                    </div>

                    <div class="separator my-10"></div>

                    <div>
                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                        <button type="button" class="btn btn-light ms-5" @click="cancel()">Vazgeç</button>
                    </div>

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

const props = defineProps({
    renderAs:{
        type:String,
        default:"inertia"
    },
    onDone:{
        type:Function,
        default:() => {}
    },
    lang:{
        type:String,
        default:null
    },
    buttonClass:{
        type:String,
        default:'btn fw-bold btn-sm btn-success d-flex align-items-center'
    },
    buttonText:{
        type:String,
        default:'<i class="bi bi-person-plus fs-4"></i><span class="ms-1 lh-1">EKLE</span>'
    },
    uuid:{
        type:String,
        default:""
    },
    fromId:{
        type:Number,
        default:null
    }
});


const dialogVisible = ref(false);

let curr_language = props.lang ?? usePage().props.current_language;

const form = useForm({
    name:"",
    language:curr_language,
    uuid:props.uuid,
    fromId:props.fromId
});

const cancel = () => {
    dialogVisible.value = false;
    form.reset();
};

const create = () => {

    if( props.renderAs == 'fetch' ){

        if( form.name == "") return;

        fetch(route('tags.store'),{
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': usePage().props.csrf_token
            },
            body: JSON.stringify(form)
        }).then(function (response) {
            return response.json();
        }).then((json) => {
            props.onDone(json.data);
            cancel();
        });

    } else {
        form.post(route('tags.store'),{
            onSuccess: () => {
                form.reset();
                dialogVisible.value = false;
            },
        });
    }

}


</script>