<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">WITH LABEL</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.withLabel" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Attribute</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.attribute" :options="attributeList" optionLabel="name" class="w-100" />
            </div>
        </div>
        
        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement" />

    </div>

</template>

<script setup>

import {ref,onBeforeMount} from "vue";
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

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'layout_content_attributes',
    layout:true,
    data:{
        name:"CONTENT ATTRIBUTES",
        prevHtml:"",
        elemHtml:"",
        attribute:null,
        withLabel:false,
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

        elemDetails.value.data.prevHtml = '<b>İÇERİK ÖZELLİKLERİ</b><br>'+elemDetails.value.data.attribute.name ?? 'Seçim yapılmadi';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}

const attributeList = ref(null);

const getContentAttributes = () => {

    fetch(route('content-attributes.index'),{
        headers: {
            'Accept': 'application/json',
        }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        attributeList.value = json;
    });

}

onBeforeMount(() => {
    getContentAttributes();
});

</script>