<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">MODAL ID</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.modalId" class="w-100" @input="makeSlugId"/>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">MODAL SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.size" :options="modalSizes" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">MODAL TITLE</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.title" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">EXTRA CLASSES</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.extraClasses" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">OPEN ON PAGE LOAD</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.opneOnPageLoad" />
            </div>
        </div>

        <Divider />

        <ContentArea :form="elemDetails.data" :use-sections="false" :use-containers="false" :add-section="elemDetails.data.content.length == 0 ? true : false" confirmGroup="modal"/>

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
import ContentArea from './ContentArea';
import {slugify} from "./design-elements-data.js";

const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'modal_window',
    render_blade:true,
    blade:'modal-window',
    data:{
        name:"MODAL WINDOW",
        modalId:"",
        prevHtml:"",
        elemHtml:"",
        size:"",
        title:"",
        extraClasses:"",
        opneOnPageLoad:false,
        content:[]
    }
};

let modalSizes = [
    {
        label:"Default Size",
        value:""
    },
    {
        label:"Small",
        value:"modal-sm"
    },
    {
        label:"Large",
        value:"modal-lg"
    },
    {
        label:"Extra Large",
        value:"modal-xl"
    },
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

const makeSlugId = () => {
    let sluggyModalId = slugify(elemDetails.value.data.modalId);
    elemDetails.value.data.modalId = sluggyModalId;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.modalId == "" ){
            resolve(false);
        }

        let prev_html = '<b>Modal Window ID: </b>'+elemDetails.value.data.modalId;

        elemDetails.value.data.prevHtml = prev_html;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    } else {
        alert("Modal ID zorunludur.!");
    }
    
    
}


</script>