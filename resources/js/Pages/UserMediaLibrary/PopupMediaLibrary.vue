<template>
    
    <div>
        <button type="button" class="btn btn-sm btn-light-primary" @click="visible=true">{{ props.buttonText }}</button>
        <Dialog v-model:visible="visible" modal header="Medya Kütüphanesi" class="p-dialog-fullscreen" @show="show" @hide="hide">

            <div class="d-flex flex-column h-100">

                <div class="d-flex flex-row justify-content-between">
                    <input type="text" class="form-control form-control-solid w-200px" placeholder="Ara..." v-model="params.search">
                    <UploadFilesDropzone :upload-done="newFilesAdded" :from="'popup'" :accept="props.mimeType"/>
                </div>

                <Divider />

                <div class="row g-4 g-lg-10">

                    <div class="col-6 col-xl-8 col-xxl-9">
                        <div class="d-flex flex-row flex-wrap gap-4 mb-10 mb-lg-0 justify-content-around">

                            <PopupMediaPreview 
                                v-for="(media,index) in data" 
                                :key="index"
                                :media="media"
                                @click="mediaSelect(media)" :active-class="getClickItemIndexInSelectedFiles(media.id) > -1 ? 'bg-opacity-60 bg-dark p-2 text-white' : ''"
                            />

                            <Divider />

                            <div>
                                <button type="button" class="btn btn-primary" @click="getMediaData(next_page_url)" v-if="next_page_url" :class="{'opacity-25':loading}" :disabled="loading">Daha fazla...</button>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-4 col-xxl-3">

                        <div class="bg-light p-5 border sticky-top h-100">

                            <div v-if="selectedFiles.length && !multiple">
                            
                                <img :src="selectedFiles[0].original_url" class="img-fluid rounded mb-5 bg-opacity-25 bg-dark p-1" />

                                <div>
                                    <button type="button" class="btn btn-primary btn-sm" @click="onSelect(selectedFiles[0],props.formModel);visible = false">Ekle</button>
                                </div>

                            </div>

                            <div v-if="selectedFiles.length && multiple">
                                
                                <div class="row g-3 row-cols-3 mb-5">

                                    <div class="col" v-for="(media,m) in selectedFiles" :key="m">
                                        <div class="overlay overflow-hidden rounded">
                                            <div class="overlay-wrapper">
                                                <img :src="media.preview_url" class="img-fluid rounded cursor-pointer" />
                                            </div>
                                            <div class="overlay-layer bg-dark bg-opacity-25">
                                                <button type="button" class="btn btn-light-danger btn-sm btn-icon" @click="mediaSelect(media)"><i class="bi bi-x fs-3"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <button type="button" class="btn btn-primary btn-sm" @click="onSelect(selectedFiles,props.formModel);visible = false">Ekle</button>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </Dialog>
    </div>

</template>

<script setup>

import {ref,reactive,watch} from "vue";
import debounce from "lodash/debounce";
import Dialog from "primevue/dialog";
import Divider from 'primevue/divider';
import qs from "qs";
import PopupMediaPreview from "./PopupMediaPreview";
import UploadFilesDropzone from './UploadFilesDropzone';

const props = defineProps({
    multiple:{
        type:Boolean,
        default:false
    },
    formModel:{
        type:[String,Object],
        required:false,
        default:null
    },
    onSelect:{
        type:Function,
        required:true
    },
    sizeSelection:{
        type:Boolean,
        default:true
    },
    buttonText:{
        type:[String],
        default:"Seç"
    },
    mimeType:{
        type:[String],
        default:""
    }
});

const visible = ref(false);
const data = ref([]);
const links = ref([]);
const next_page_url = ref(null);
const loading = ref(false);

const selectedFiles = ref([]);

const mediaSelect = (media) => {

    const mediaIndexInSelectedFiles = getClickItemIndexInSelectedFiles(media.id);

    if( props.multiple ){

        if( mediaIndexInSelectedFiles > -1 ){

            selectedFiles.value.splice(mediaIndexInSelectedFiles, 1);

        } else {

            selectedFiles.value.push(media);

        }

        return;
    }

    //multiple ise buraya girmiyor hic
    if( mediaIndexInSelectedFiles > -1 ){

        selectedFiles.value = [];

    } else {

        selectedFiles.value = [media];

    }
    
}

const getClickItemIndexInSelectedFiles = (mediaId) => {
    return selectedFiles.value.findIndex((obj) => obj.id === mediaId);
}

const params = reactive({
    search:"",
    mimeType:props.mimeType
});

const getMediaData = (uri) => {

    loading.value = true;

    fetch(uri,{
        headers: {
            'Accept': 'application/json',
        }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        data.value = [...data.value, ...json.data,];
        links.value = json.links;
        next_page_url.value = json.next_page_url.replace(json.path,"/admin/user-medias");
        loading.value = false;
    }).catch((error) => {
        console.log("Error:", error);
        loading.value = false;
    });
    
}

const show = () => {

    getMediaData(route('user-medias.index')+'?'+qs.stringify(params));

}

const hide = () => {
    params.search = "";
    data.value = [];
    selectedFiles.value = [];

}

const newFilesAdded = () => {

    params.search = "";
    data.value = [];
    getMediaData(route('user-medias.index')+'?'+qs.stringify(params));

}


watch(() => ([params.search]), debounce(function (){
    
    data.value = [];
    selectedFiles.value = [];
    getMediaData(route('user-medias.index')+'?'+qs.stringify(params));

},500));


</script>