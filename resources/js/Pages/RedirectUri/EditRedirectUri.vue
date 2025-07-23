<template>
    
    <div>

        <Dialog v-model:visible="dialogVisible" modal @hide="props.onUpdateDone" header="Ürün Kategorisi Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update">

                <div>
                    <div class="d-flex flex-column">
                        <label class="form-label">Eski URL</label>
                        <InputText v-model="form.old" class="w-100" />
                    </div>

                    <Divider />

                    <div class="d-flex flex-column">
                        <label class="form-label">Yönlendirilecek URL</label>
                        <InputText v-model="form.new" class="w-100" />
                    </div>

                    <Divider />

                    <div class="row align-items-center">
                        <label class="col-md-6 form-label">Yönlendirme Tipi</label>
                        <div class="col-md-6">
                            <Dropdown v-model="form.redirect_type" :options="[301,302]" class="w-100" />
                        </div>
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
import Dropdown from 'primevue/dropdown';
import Divider from "primevue/divider";

const props = defineProps({
    selectedRedirectUri:Object,
    appUrl:String,
    onUpdateDone:{
        type:Function,
        required:true
    }
});


const dialogVisible = ref(true);

const form = useForm({
    old:props.selectedRedirectUri.old,
    new:props.selectedRedirectUri.new,
    redirect_type:props.selectedRedirectUri.redirect_type,
});

const cancel = () => {
    form.reset();
    props.onUpdateDone();
};

const update = () => {
    form.put(route('redirect-uris.update',props.selectedRedirectUri),{
        onSuccess: () => {
            form.reset();
            props.onUpdateDone();
        },
    });
}


</script>