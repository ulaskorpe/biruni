<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SELECT TEMPLATE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.design_template" :options="design_templates" optionLabel="name" placeholder="Select" class="w-100" />
            </div>
        </div>

        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement"/>

    </div>

</template>

<script setup>

import {ref,onMounted} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import ColumnCounts from "./ColumnCounts";
import OrderByOptions from "./OrderByOptions";
import Slider from 'primevue/slider';


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'design_template',
    widget:true,
    data:{
        name:"Ürün Kategoriler",
        prevHtml:"",
        elemHtml:"",
        design_template:{},
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


const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const design_templates = ref(null);

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        elemDetails.value.data.prevHtml = 'Şablon: '+elemDetails.value.data.design_template.name;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}

onMounted(() => {
   
    fetch(route('design-templates.index'),{
        headers:{
            'Accept':'application/json'
        }
    }).then(function(response) {
        return response.json();
    }).then((json) => {
        design_templates.value = json;
    });
    
});

</script>