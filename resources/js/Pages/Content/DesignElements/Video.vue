<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">VIDEO Type</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.video_type" :options="videoType" class="w-100" />
            </div>
        </div>

        <Divider />

        <div v-if="elemDetails.data.video_type != 'html5'">
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">VIDEO code</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.video_code" class="w-100" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.video_type == 'html5'">
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">select video</label>
                <div class="col-md-9">
                    <div class="d-flex flex-column">
                        <div class="bg-light p-3 mb-3" v-if="elemDetails.data.html_video">
                            <video controls class="w-100">
                                <source :src="elemDetails.data.html_video.original_url" type="video/mp4">
                            </video>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <PopupMediaLibrary :on-select="setMainVideo" :button-text="'Seç'" :mime-type="'video/'" :key="Math.floor(Math.random() * 100000)"/>
                            <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="elemDetails.data.html_video" @click="elemDetails.data.html_video = null">Kaldır</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">View Type</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.view_type" :options="viewType" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SELECT IMAGE</label>
            <div class="col-md-9">
                <div class="d-flex flex-row flex-wrap align-items-end">
                    <div class="symbol symbol-100px me-2">
                        <img :src="elemDetails.data.poster.preview_url" v-if="elemDetails.data.poster"/>
                        <div class="symbol-label" v-else>
                            <i class="bi bi-image fs-2x"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <PopupMediaLibrary v-if="!elemDetails.data.poster" :on-select="setSingleImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                        <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="elemDetails.data.poster" @click="elemDetails.data.poster = null">
                            <i class="bi bi-x fs-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ALT TEXT</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.altText" class="w-100" />
            </div>
        </div>

        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement"/>

    </div>

</template>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

const editor = ref(null);

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'video',
    data:{
        name:"VIDEO",
        poster:null,
        poster_id:null,
        video_code:"",
        html_video:null,
        altText:"",
        video_type:"",
        view_type:"lightbox",
        prevHtml:"",
        elemHtml:"",
        baseDesignOptions:{
            class: "",
            position: "position-relative",
            padding: {
                top: "",
                right: "",
                bottom: "",
                left: ""
            },
            margin: {
                top: "",
                right: "",
                bottom: "",
                left: ""
            }
        },
        animOptions:{
            use: false,
            class: "",
            delay: ""
        }
    }
};

let videoType = ['youtube','vimeo','html5'];
let viewType = ['lightbox','inline'];

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const setSingleImage = (media) => {
    elemDetails.value.data.poster = media;
    elemDetails.value.data.poster_id = media.id;
}

const setMainVideo = (media) => {
    elemDetails.value.data.html_video = media;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
        if(elemDetails.value.data.baseDesignOptions.class){
            let classes = elemDetails.value.data.baseDesignOptions.class.split(' ');
            classes.forEach(cl => {
                if( cl &&  cl != ""){
                    elemDiv.classList.add(cl);
                }
            });
        }

        Object.entries(elemDetails.value.data.baseDesignOptions.padding).forEach(([key, val]) => {
            if(val && val != ""){
                elemDiv.classList.add(val);
            }
        });

        Object.entries(elemDetails.value.data.baseDesignOptions.margin).forEach(([key, val]) => {
            if(val && val != ""){
                elemDiv.classList.add(val);
            }
        });

        if(elemDetails.value.data.animOptions.use){
            
            if(elemDetails.value.data.animOptions.class && elemDetails.value.data.animOptions.class != ""){
                elemDiv.classList.add('animate__animated','anim-opacity-0');
                elemDiv.dataset.animation = elemDetails.value.data.animOptions.class;
            }

            if(elemDetails.value.data.animOptions.delay && elemDetails.value.data.animOptions.delay != ""){
                elemDiv.classList.add(elemDetails.value.data.animOptions.delay);
            }

        }

        if( elemDetails.value.data.view_type == 'lightbox' ){

            const lightboxElem = document.createElement("a");
            lightboxElem.classList.add("d-block","min-h-100px","position-relative");

            lightboxElem.setAttribute('data-fancybox','fancy-'+Math.floor(Math.random() * 100000));

            if (elemDetails.value.data.video_type == 'youtube') {
                lightboxElem.href = 'https://www.youtube.com/watch?v='+elemDetails.value.data.video_code;
            }

            if (elemDetails.value.data.video_type == 'vimeo') {
                lightboxElem.href = 'https://vimeo.com/'+elemDetails.value.data.video_code;
            }

            if (elemDetails.value.data.video_type == 'html5') {
                lightboxElem.href = elemDetails.value.data.html_video.original_url;
            }

            if( elemDetails.value.data.poster ){
                const imgElem = document.createElement("img");
                imgElem.src = elemDetails.value.data.poster.original_url;
                imgElem.alt = elemDetails.value.data.altText == null || elemDetails.value.data.altText == "" ? elemDetails.value.data.poster.name : elemDetails.value.data.altText;
                imgElem.classList.add("img-fluid");
                lightboxElem.appendChild(imgElem);
            } else {
                if (elemDetails.value.data.video_type == 'youtube') {
                    const imgElem = document.createElement("img");
                    imgElem.src = 'http://i3.ytimg.com/vi/'+elemDetails.value.data.video_code+'/maxresdefault.jpg';
                    imgElem.classList.add("img-fluid");
                    lightboxElem.appendChild(imgElem);
                }
            }

            const overlayElem = document.createElement("div");
            overlayElem.classList.add("d-flex","align-items-center","justify-content-center","overlay","bg-opacity-25","bg-primary");
            overlayElem.innerHTML = '<i class="bi bi-play-circle-fill text-white display-3"></i>';

            lightboxElem.appendChild(overlayElem);

            elemDiv.appendChild(lightboxElem);

        }

        if( elemDetails.value.data.view_type == 'inline' ){

            const videoElem = document.createElement("div");

            if (elemDetails.value.data.video_type == 'youtube') {

                videoElem.classList.add("ratio","ratio-16x9");
                videoElem.innerHTML = '<iframe src="https://www.youtube.com/embed/'+elemDetails.value.data.video_code+'" allowfullscreen></iframe>';
            }

            if (elemDetails.value.data.video_type == 'vimeo') {
                videoElem.classList.add("ratio","ratio-16x9");
                videoElem.innerHTML = '<iframe src="https://player.vimeo.com/video/'+elemDetails.value.data.video_code+'" width="640" height="564" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe>';
            }

            if (elemDetails.value.data.video_type == 'html5') {
                const html5VideoElem = document.createElement("video");
                html5VideoElem.controls = true;
                html5VideoElem.classList.add("w-100");
                if( elemDetails.value.data.poster ){
                    html5VideoElem.setAttribute("poster",elemDetails.value.data.poster.original_url);
                }

                html5VideoElem.innerHTML = '<source src="'+elemDetails.value.data.html_video.original_url+'" type="video/mp4">';
                videoElem.appendChild(html5VideoElem);
            }

            elemDiv.appendChild(videoElem);

        }

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = 'VIDEO ELEMENT: '+elemDetails.value.data.video_type;
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


</script>