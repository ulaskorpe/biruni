<template>
    
    <Button icon="bi bi-person-circle" text rounded severity="secondary" @click="dialogVisible = true"/>

    <Dialog v-model:visible="dialogVisible" modal header="Kullanıcı Avatar Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
        <FileUpload name="avatar" 
        :fileLimit="1" 
        :url="route('users.avatar',props.user)" 
        @upload="onUploadDone($event)" 
        @before-send="beforeUpload" 
        :multiple="false" 
        accept="image/*" 
        :maxFileSize="1000000">
            <template #empty>
                <p>Drag and drop files to here to upload.</p>
            </template>
        </FileUpload>
    </Dialog>
</template>

<script setup>

import {ref,inject,onMounted} from "vue";
import {usePage} from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';

const props = defineProps({
    user:Object,
    reloadUri:String
});

const dialogVisible = ref(false);
const refreshUser = inject('refreshUser');

const onUploadDone = (event) => {
    dialogVisible.value = false;
    refreshUser(JSON.parse(event.xhr.responseText));
};
const beforeUpload = (event) => {
    event.xhr.setRequestHeader('X-CSRF-TOKEN', usePage().props.csrf_token);
    return event;
}

</script>