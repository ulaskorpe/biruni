<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CATEGORIES</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.categories" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TAGS</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.tags" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">AUTHOR</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.author" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DATE</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.date" />
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
    type:'layout_meta_data',
    layout:true,
    data:{
        name:"CONTENT META DATA",
        prevHtml:"",
        elemHtml:"",
        categories:false,
        tags:false,
        author:false,
        date:false,
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

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        let prev_html = '<div class="vstack gap-3">';
            
            prev_html += '<b>İÇERİK META BİLGİLERİ</b>';

            prev_html += '<div class="vstack gap-1">';
                prev_html += '<small><b>Kategoriler</b>: '+elemDetails.value.data.categories+'</small>';
                prev_html += '<small><b>Etiketler</b>: '+elemDetails.value.data.tags+'</small>';
                prev_html += '<small><b>Yazar</b>: '+elemDetails.value.data.author+'</small>';
                prev_html += '<small><b>Tarih</b>: '+elemDetails.value.data.date+'</small>';
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