<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TAG</label>
            <div class="col-md-9">
                <div class="d-flex gap-4">
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h2" name="tag" value="h2" />
                        <label for="title-tag-h2" class="ms-2">H2</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h3" name="tag" value="h3" />
                        <label for="title-tag-h3" class="ms-2">H3</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h4" name="tag" value="h4" />
                        <label for="title-tag-h4" class="ms-2">H4</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h5" name="tag" value="h5" />
                        <label for="title-tag-h5" class="ms-2">H5</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h6" name="tag" value="h6" />
                        <label for="title-tag-h6" class="ms-2">H6</label>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DISPLAY SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.size" :options="displaySizes" optionValue="value" optionLabel="label" class="w-100" />
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
import Dropdown from "primevue/dropdown";
import RadioButton from 'primevue/radiobutton';
import BaseDesignOptions from "./BaseDesignOptions";
import {displaySizes} from "./design-elements-data.js";

const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'layout_subtitle',
    layout:true,
    data:{
        name:"CONTENT SUBTITLE",
        tag:"h2",
        size:"",
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


const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement(elemDetails.value.data.tag);

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
        if(elemDetails.value.data.baseDesignOptions.class){
            let classes = elemDetails.value.data.baseDesignOptions.class.split(' ');
            classes.forEach(cl => {
                if( cl &&  cl != ""){
                    elemDiv.classList.add(cl);
                }
            });
        }

        if(elemDetails.value.data.size && elemDetails.value.data.size != ""){
            
            elemDiv.classList.add(elemDetails.value.data.size);

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

        elemDiv.innerHTML = 'TITLE';

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = '<b>SAYFA ALT BAŞLIĞI</b>';
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


</script>