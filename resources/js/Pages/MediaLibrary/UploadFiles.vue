<template>
    
    <button type="button" class="btn fw-bold btn-sm btn-success d-flex align-items-center" @click="dialogVisible = true"><i class="bi bi-folder-plus fs-3"></i><span class="ms-1 lh-1">EKLE</span></button>

    <Dialog v-model:visible="dialogVisible" modal header="Yeni medya ekle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
        
        <FileUpload name="files[]" 
        :fileLimit="10" 
        :url="route('medias.store')" 
        @upload="onUploadDone($event)" 
        @before-send="beforeUpload" 
        :multiple="true" 
        :accept="props.accept ? `${props.accept}*` : ''" 
        :maxFileSize="5000000">
            <template #empty>
                <p>Yüklenecek dosyaları buraya bırakın. Tek seferde en fazla 10 dosya yükleyebilirsiniz.</p>
            </template>
        </FileUpload>

    </Dialog>

    <BlockUI :blocked="blocked" fullScreen></BlockUI>
</template>

<script setup>

import {ref} from "vue";
import {usePage, router} from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';
import BlockUI from 'primevue/blockui';

const props = defineProps({
    uploadDone:{
        type:Function,
        required:false
    },
    from:{
        type:String,
        default:"page"
    },
    accept:{
        type:String,
        default:null
    }
});

const dialogVisible = ref(false);
const blocked = ref(false);

const onUploadDone = (event) => {

    blocked.value = false;
    dialogVisible.value = false;

    if( props.from == "popup" ){
        props.uploadDone();
    } else {
        router.get(route('medias.index'));
    }

};
const beforeUpload = (event) => {
    event.xhr.setRequestHeader('X-CSRF-TOKEN', usePage().props.csrf_token);
    blocked.value = true;
    return event;
}

</script>