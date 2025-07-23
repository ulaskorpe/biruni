<template>
    
    <div>
        <Button icon="bi bi-eye text-primary" text rounded severity="info" @click="visible = true"/>

        <Dialog v-model:visible="visible" modal :header="props.media.name" @show="mediaDetails" class="p-dialog-fullscreen">

            <div class="row g-4 g-lg-5 g-xxl-10">
                <div class="col-lg-8">

                    <div v-if="props.media.mime_type.startsWith('image/')">
                        <img :src="props.media.original_url" class="img-fluid"/>
                    </div>

                    <div v-if="props.media.mime_type.startsWith('video/')">
                        <video class="object-fit-cover" controls>
                            <source :src="props.media.original_url" type="video/mp4">
                        </video>
                    </div>

                    <div v-if="props.media.mime_type.startsWith('audio/')">
                        <audio class="w-100" controls>
                            <source :src="props.media.original_url" type="audio/mpeg">
                        </audio>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="mb-5">
                        <div class="mb-5">
                            <label class="form-label">Dosya adresi</label>
                            <div class="d-flex flex-row">
                                <InputText v-model="props.media.original_url" class="flex-grow-1 border"/>
                                <Button icon="bi bi-front fs-3" severity="secondary" text outlined class="copy-button ms-2" :data-clipboard-text="props.media.original_url" v-tooltip.top="copyTooltip"/>
                            </div>
                        </div>
                        <div v-if="props.media.mime_type.startsWith('image/')">
                            <div class="">
                                <label class="form-label">Önizleme adresi</label>
                                <div class="d-flex flex-row">
                                    <InputText v-model="props.media.preview_url" class="flex-grow-1 border"/>
                                    <Button icon="bi bi-front fs-3" severity="secondary" text outlined class="ms-2" :data-clipboard-text="props.media.preview_url" v-tooltip.top="copyTooltip"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded bg-light p-4 p-xl-5 p-xxl-7 mb-5">
                        <form @submit.prevent="updateMedia">
                            <div class="mb-5">
                                <label class="form-label">ALT Başlık</label>
                                <InputText v-model="form.name" class="w-100" />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Dosya Adı</label>
                                <div class="p-inputgroup">
                                    <InputText v-model="form.file_name" />
                                    <span class="p-inputgroup-addon">.{{ props.media.custom_properties.ext }}</span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Güncelle</button>
                        </form>
                        <FormErrors :form="form"/>
                    </div>
                </div>
            </div>

        </Dialog>

    </div>

</template>

<script setup>

import {computed, onMounted, ref} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

const props = defineProps({
    media:Object,
});


const visible = ref(false);
let copyTooltip = ref("Kopyala");

let file_name_without_ext = "";

const updateFileNameWithoutExt = (file_name) => {
    let file_name_arr = file_name.value.split('.');
    file_name_arr.pop();
    file_name_without_ext = file_name_arr.join('.');
}
updateFileNameWithoutExt(computed(() => props.media.file_name));


const form = useForm({
    name:props.media.name,
    file_name:file_name_without_ext
});

const updateMedia = () => {
    form.put(route('medias.update',props.media),{
        preserveScroll: true,
        onSuccess: () => {
            //visible.value = false;
            updateFileNameWithoutExt(computed(() => props.media.file_name));
            form.file_name = file_name_without_ext;
        }
    });
}

const mediaDetails = () => {

    fetch(route('medias.show',props.media.id),{
        headers: {
            'Accept': 'application/json',
        }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        console.log(json);
    });

}

onMounted(() => {
    var clipboard = new ClipboardJS('[data-clipboard-text]');
    clipboard.on('success', function(e) {
        var btn = e.trigger.querySelector('.p-button-icon');
        btn.classList.remove('bi-front');
        btn.classList.add('bi-check-square-fill');
        setTimeout(() => {
            btn.classList.remove('bi-check-square-fill');
            btn.classList.add('bi-front');
        }, 1000);
        e.clearSelection();
    });
});
</script>