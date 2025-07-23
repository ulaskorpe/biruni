<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SELECT IMAGE</label>
            <div class="col-md-9">
                <div class="d-flex flex-row flex-wrap align-items-end">
                    <div class="symbol symbol-100px me-2">
                        <img :src="elemDetails.data.media.preview_url" v-if="elemDetails.data.media"/>
                        <div class="symbol-label" v-else>
                            <i class="bi bi-image fs-2x"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <PopupMediaLibrary v-if="!elemDetails.data.media" :on-select="setSingleImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                        <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="elemDetails.data.media" @click="elemDetails.data.media = null">
                            <i class="bi bi-x fs-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.conversion" :options="conversions" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ALT TEXT</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.altText" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LAZY LOAD</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.loading" :options="imgLoadings" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>
        
        <div v-if="elemDetails.data.loading != 'lazy'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">PRELOAD</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.asPreload" />
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LIGHTBOX</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.lightbox" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LINK</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.link" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">MAX WIDTH</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imageMaxWidth" :options="minMaxWidths" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ROUNDED</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imageRounded" :options="roundeds" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SHADOW</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imageShadow" :options="shadows" optionValue="value" optionLabel="label" class="w-100" />
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
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";
import {roundeds,shadows} from "./design-elements-data.js";

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
    type:'image',
    render_blade:true,
    blade:'image',
    data:{
        name:"SINGLE IMAGE",
        media:null,
        media_id:null,
        prevHtml:"",
        elemHtml:"",
        loading:"lazy",
        asPreload:false,
        lightbox:false,
        conversion:"",
        imageMaxWidth:"",
        imageRounded:"",
        imageShadow:"",
        link:"",
        altText:"",
        src:"", //php tarafinda kullanmak icin
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
            },
            columnSize:{
                sm:"col-12",
                md:"col-md-6",
                lg:"col-lg-6",
                xl:"col-xl-6",
            }
        },
        animOptions:{
            use: false,
            class: "",
            delay: ""
        }
    }
};

let imgLoadings = [
    {
        label:"Default",
        value:""
    },
    {
        label:"Lazy",
        value:"lazy"
    },
    {
        label:"Eager",
        value:"eager"
    }
];

let conversions = [
    {
        label:"Default Size",
        value:""
    },
    {
        label:"Optimize",
        value:"op_url"
    },
    {
        label:"Thumbnail",
        value:"th_url"
    },
    {
        label:"992x500",
        value:"992x500_url"
    },
    {
        label:"500x500",
        value:"500x500_url"
    },
    {
        label:"300x300",
        value:"300x300_url"
    },
    {
        label:"1200x1200",
        value:"1200x1200_url"
    },
    {
        label:"100x100",
        value:"100x100_url"
    }
];

let minMaxWidths = [
    {
        label:"Default 100%",
        value:""
    },
    {
        label:"25px",
        value:"mw-25px"
    },
    {
        label:"30px",
        value:"mw-30px"
    },
    {
        label:"35px",
        value:"mw-35px"
    },
    {
        label:"40px",
        value:"mw-40px"
    },
    {
        label:"50px",
        value:"mw-50px"
    },
    {
        label:"75px",
        value:"mw-75px"
    },
    {
        label:"100px",
        value:"mw-100px"
    },
    {
        label:"125px",
        value:"mw-125px"
    },
    {
        label:"150px",
        value:"mw-150px"
    },
    {
        label:"175px",
        value:"mw-175px"
    },
    {
        label:"200px",
        value:"mw-200px"
    },
    {
        label:"225px",
        value:"mw-225px"
    },
    {
        label:"250px",
        value:"mw-250px"
    },
    {
        label:"275px",
        value:"mw-275px"
    },
    {
        label:"300px",
        value:"mw-300px"
    },
];

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
    elemDetails.value.data.media = media;
    elemDetails.value.data.media_id = media.id;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( !elemDetails.value.data.media ){
            resolve(false);
        }

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("img");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
        const linkElem = document.createElement("a");

        elemDiv.classList.add("img-fluid");

        if( elemDetails.value.data.loading && elemDetails.value.data.loading != "" ){
            elemDiv.setAttribute('loading', elemDetails.value.data.loading);
        }

        if(elemDetails.value.data.baseDesignOptions.class){
            let classes = elemDetails.value.data.baseDesignOptions.class.split(' ');
            classes.forEach(cl => {
                if( cl &&  cl != ""){
                    elemDiv.classList.add(cl);
                }
            });
        }

        if( elemDetails.value.data.imageMaxWidth && elemDetails.value.data.imageMaxWidth != "" && elemDetails.value.data.imageMaxWidth != null ){
            elemDiv.classList.add(elemDetails.value.data.imageMaxWidth);
        }
        if( elemDetails.value.data.imageRounded && elemDetails.value.data.imageRounded != "" && elemDetails.value.data.imageRounded != null ){
            let roundedClasses = elemDetails.value.data.imageRounded.split(' ');
            roundedClasses.forEach(cl => {
                if( cl &&  cl != ""){
                    elemDiv.classList.add(cl);
                }
            });
        }
        if( elemDetails.value.data.imageShadow && elemDetails.value.data.imageShadow != "" && elemDetails.value.data.imageShadow != null ){
            elemDiv.classList.add(elemDetails.value.data.imageShadow);
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

        
        if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" || elemDetails.value.data.conversion == null ){

            elemDetails.value.data.src = elemDetails.value.data.media.original_url;
            elemDiv.src = elemDetails.value.data.media.original_url;
            elemDiv.width = elemDetails.value.data.media.custom_properties.width;
            elemDiv.height = elemDetails.value.data.media.custom_properties.height;

        } else {

            elemDetails.value.data.src = elemDetails.value.data.media.conversion_urls[elemDetails.value.data.conversion];
            elemDiv.src = elemDetails.value.data.media.conversion_urls[elemDetails.value.data.conversion];

            switch (elemDetails.value.data.conversion) {
                case "op_url":
                //elemDiv.width = 1300;
                elemDiv.width = elemDetails.value.data.media.custom_properties.op_width;
                elemDiv.height = elemDetails.value.data.media.custom_properties.op_height;
                break;
            
                case "th_url":
                elemDiv.width = elemDetails.value.data.media.custom_properties.th_width;
                elemDiv.height = elemDetails.value.data.media.custom_properties.th_height;
                break;

                default:
                let convArr = elemDetails.value.data.conversion.replace('_url','').split('x')
                elemDiv.width = convArr[0];
                elemDiv.height = convArr[1];
                break;
            }

            if( elemDetails.value.data.conversion == 'op' ){
                elemDiv.width = 1300;
            }
        }

        elemDiv.alt = elemDetails.value.data.altText == null || elemDetails.value.data.altText == "" ? elemDetails.value.data.media.name : elemDetails.value.data.altText;

        if( elemDetails.value.data.link != null && elemDetails.value.data.link != 'null' && elemDetails.value.data.link != "" ){

            linkElem.href = elemDetails.value.data.link;
            linkElem.appendChild(elemDiv);
            htmlDiv.appendChild(linkElem);

        } else if (elemDetails.value.data.lightbox) {

            linkElem.href = elemDetails.value.data.media.original_url;
            linkElem.dataset.fancybox = elemDetails.value.id;
            linkElem.appendChild(elemDiv);
            htmlDiv.appendChild(linkElem);

        } else {
            htmlDiv.appendChild(elemDiv);
        }


        let prev_html = '<div class="hstack gap-3">';
            
            prev_html += '<img src="'+elemDetails.value.data.media.preview_url+'" width="100" />';

            prev_html += '<div class="vstack gap-1">';
                prev_html += '<small><b>ALT</b>: '+elemDetails.value.data.altText+'</small>';
                prev_html += '<small><b>LIGHTBOX</b>: '+elemDetails.value.data.lightbox+'</small>';
                prev_html += '<small><b>LINK</b>: '+elemDetails.value.data.link+'</small>';
            prev_html += '</div>';

        prev_html += '</div>';

        elemDetails.value.data.prevHtml = prev_html;
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


/*
watch(elemDetails.value, () => {

    const htmlDiv = document.createElement("div");
    const title = document.createElement(elemDetails.value.data.tag);
    title.innerText = elemDetails.value.data.text;
    title.classList.add("asd")
    htmlDiv.appendChild(title);

    elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
    elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

});
*/

</script>