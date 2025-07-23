<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TEXT</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.text" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMAGE</label>
            <div class="col-md-9">
                <div class="d-flex flex-row align-items-center">
                    <img :src="elemDetails.data.buttonMedia.original_url" v-if="elemDetails.data.buttonMedia" class="img-thumbnail" width="100"/>
                    <PopupMediaLibrary v-if="!elemDetails.data.buttonMedia" :on-select="setAccMedia" :form-model="elemDetails.data.buttonMedia" :button-text="'Görsel Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" @click="elemDetails.data.buttonMedia = null" v-if="elemDetails.data.buttonMedia">
                        <i class="bi bi-x fs-3"></i>
                    </button>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ICON</label>
            <div class="col-md-9">

                <div class="row g-3">
                    <div class="col-6">
                        <label class="">Icon</label>
                        <Dropdown v-model="elemDetails.data.icon" :options="bootstrapIcons" optionValue="icon" optionLabel="icon" :virtualScrollerOptions="{ itemSize: 30 }" showClear filter placeholder="Select icon" class="w-100">
                
                            <template #value="slotProps">
                                <div class="d-flex flex-row align-items-center" v-if="slotProps.value">
                                    <i :class="`bi bi-${slotProps.value}`"></i>
                                    <span v-html="slotProps.value" class="ms-3"></span>
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                            <template #option="slotProps">
                                <div class="d-flex flex-row align-items-center">
                                    <i :class="`bi bi-${slotProps.option.icon} fs-1`"></i>
                                    <span v-html="slotProps.option.icon" class="ms-3"></span>
                                </div>
                            </template>

                        </Dropdown>
                    </div>
                    <div class="col-6">
                        <label class="">Position</label>
                        <Dropdown v-model="elemDetails.data.iconPosition" :options="iconPositions" class="w-100" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.buttonOptions.type" :options="buttonOptions.type" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <div v-if="elemDetails.type == 'button'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">LINK</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.link" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">REL</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.rel" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">NEW WINDOW</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.new_window"/>
                </div>
            </div>
        </div>

        <div v-if="elemDetails.type == 'modal_button'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">MODAL ID</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.link" class="w-100" />
                </div>
            </div>

        </div>

        <div v-if="elemDetails.type == 'offcanvas_button'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">OFFCANVAS ID</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.link" class="w-100" />
                </div>
            </div>

        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.buttonOptions.size" :options="buttonOptions.size" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement"/>

    </div>

</template>

<style>
.p-dropdown-item {
    height:auto !important;
}
</style>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";
import InputSwitch from "primevue/inputswitch";
import BaseDesignOptions from "./BaseDesignOptions";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";
import {buttonOptions} from "./design-elements-data.js";
import {bootstrapIcons} from "./bootstrap-icons.js";


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function,
    forModal:{
        type:Boolean,
        default:false
    },
    forOffCanvas:{
        type:Boolean,
        default:false
    }
});

let elemType = 'button';
if( props.forModal ){
    elemType = 'modal_button';
}
if( props.forOffCanvas ){
    elemType = 'offcanvas_button';
}

let emptyElem = {
    id:"elem_" + Date.now(),
    type:elemType,
    data:{
        name:"BUTTON",
        prevHtml:"",
        elemHtml:"",
        link:"",
        text:"",
        icon:"",
        iconPosition:"left",
        buttonMedia:null,
        buttonOptions:{
            type:"btn-default",
            size:"",
        },
        new_window:false,
        rel:"",
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

let iconPositions = ["left","right"];

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const setAccMedia = (media) => {
    elemDetails.value.data.buttonMedia = media;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.link == "" ){
            resolve(false);
        }

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("a");

        elemDiv.classList.add("btn");
        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

        Object.entries(elemDetails.value.data.buttonOptions).forEach(([key, val]) => {
            if(val && val != ""){
                elemDiv.classList.add(val);
            }
        });

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

        let buttonText = "";

        if( elemDetails.value.data.icon != "" && elemDetails.value.data.icon != null && elemDetails.value.data.icon != "null" && elemDetails.value.data.iconPosition == "left" ){
            buttonText += '<i class="bi bi-'+elemDetails.value.data.icon+' pe-2"></i>';
        }

        buttonText += elemDetails.value.data.text;

        if( elemDetails.value.data.icon != "" && elemDetails.value.data.icon != null && elemDetails.value.data.icon != "null" && elemDetails.value.data.iconPosition == "right" ){
            buttonText += '<i class="bi bi-'+elemDetails.value.data.icon+' ps-2"></i>';
        }

        if( elemDetails.value.data.buttonMedia ){
            
            elemDiv.classList.add("d-inline-flex","align-items-center","gap-3");
            buttonText += `<img loading="lazy" class="img-fluid" src="${elemDetails.value.data.buttonMedia.original_url}" width="${elemDetails.value.data.buttonMedia.custom_properties.width}" height="${elemDetails.value.data.buttonMedia.custom_properties.height}">`;

        }

        elemDiv.innerHTML = buttonText;
        elemDiv.href = elemDetails.value.data.link;

        if( elemDetails.value.type == 'modal_button' ){
            elemDiv.setAttribute('data-bs-toggle','modal');
            elemDiv.setAttribute('role','button');
            elemDiv.href = '#'+elemDetails.value.data.link;
        }

        if( elemDetails.value.type == 'offcanvas_button' ){
            elemDiv.setAttribute('data-bs-toggle','offcanvas');
            elemDiv.setAttribute('role','button');
            elemDiv.href = '#offcanvas-'+elemDetails.value.data.link;
        }

        if( elemDetails.value.data.new_window && elemDetails.value.data.new_window === true ){
            elemDiv.target = "_blank";
        }

        if( elemDetails.value.data.rel && elemDetails.value.data.iconPosition != "" ){
            elemDiv.rel = elemDetails.value.data.rel;
        }

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
        elemDetails.value.data.elemHtml = '<div>'+htmlDiv.innerHTML+'</div>';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    } else {
        if( elemDetails.value.type == 'modal_button' ){
            alert("Modal ID zorunludur.!");
        } else if( elemDetails.value.type == 'offcanvas_button' ){
            alert("OffCanvas ID ID zorunludur.!");
        } else {
            alert("Link alanı zorunludur!");
        }
    }
}


</script>