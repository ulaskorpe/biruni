<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.conversion" :options="conversions" optionValue="value" optionLabel="label" class="w-100" />
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
            <label class="col-md-3 fw-bold text-uppercase">TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.type" :options="['grid','carousel']" class="w-100" />
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
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";


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
    type:'layout_gallery_images',
    layout:true,
    data:{
        name:"CONTENT GALLERY IMAGES",
        prevHtml:"",
        elemHtml:"",
        lightbox:false,
        conversion:"",
        type:"carousel",
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
]

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

        let prev_html = '<div class="hstack gap-3">';
            
            prev_html += '<b>İÇERİK GALERİ GÖRSELLERİ</b>';

            prev_html += '<div class="vstack gap-1">';
                prev_html += '<small><b>LIGHTBOX</b>: '+elemDetails.value.data.lightbox+'</small>';
                prev_html += '<small><b>TYPE</b>: '+elemDetails.value.data.type+'</small>';
            prev_html += '</div>';

        prev_html += '</div>';

        elemDetails.value.data.prevHtml = prev_html;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


</script>