<template>
    
    <div>
        <button type="button" class="btn btn-sm btn-success" @click="dialogVisible = true">Yeni</button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Yönlendirme Kuralı" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="create">

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
    appUrl:String
});


const dialogVisible = ref(false);

const form = useForm({
    old:"",
    new:"",
    redirect_type:301
});

const cancel = () => {
    dialogVisible.value = false;
    form.reset();
};

const create = () => {
    form.post(route('redirect-uris.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

</script>