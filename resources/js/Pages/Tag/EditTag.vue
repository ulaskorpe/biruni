<template>
    
    <div>

        <Dialog v-model:visible="dialogVisible" modal @hide="props.onUpdateDone" header="Etiket Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update">

                <div>

                    <div class="d-flex flex-column">
                        <label class="form-label">İSİM</label>
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
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';

const props = defineProps({
    selectedTag:Object,
    onUpdateDone:{
        type:Function,
        required:true
    }
});


const dialogVisible = ref(true);

const form = useForm({
    name:props.selectedTag.name,
});

const cancel = () => {
    form.reset();
    props.onUpdateDone();
};

const update = () => {
    form.put(route('tags.update',[props.selectedTag,{language:props.selectedTag.language}]),{
        onSuccess: () => {
            form.reset();
            props.onUpdateDone();
        },
    });
}

</script>