<template>
    
    <div>
        <button type="button" class="btn fw-bold btn-sm btn-success d-flex align-items-center" @click="dialogVisible = true"><i class="bi bi-folder-plus fs-3"></i><span class="ms-1 lh-1">EKLE</span></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni medya ekle" @show="makeDropzone" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">

            <div ref="dropRef" class="dropzone">
                <div class="dz-message needsclick">
                    <i class="bi bi-cloud-arrow-up fs-3x text-primary"></i>

                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                        <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                    </div>
                </div>
            </div>

        </Dialog>
    </div>

</template>

<script setup>

import {ref} from "vue";
import Dropzone from "dropzone";
import {usePage, router} from "@inertiajs/vue3";
import Dialog from "primevue/dialog";

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
const dropRef = ref(null);

const onUploadDone = () => {

    dialogVisible.value = false;

    if( props.from == "popup" ){
        props.uploadDone();
    } else {
        router.get(route('user-medias.index'));
    }

};

const makeDropzone = () => {

    if(dropRef.value !== null) {

        let uploadDropzone = new Dropzone(dropRef.value, {
            url:route('user-medias.store'),
            parallelUploads:1,
            uploadMultiple:true,
            maxFilesize:100000000,
            maxFiles:10,
            paramName:'files',
            headers:{
                "X-CSRF-TOKEN": usePage().props.csrf_token
            },
            addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
        });

        if( props.accept ){
            uploadDropzone.options.acceptedFiles = props.accept+"*"; //dropzone image/* nedense calismiyor buna bakalim.
        }

        uploadDropzone.on('queuecomplete',function() {
            onUploadDone();
        });

    }
}

</script>