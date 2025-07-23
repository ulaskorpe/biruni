<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">OFFCANVAS ID</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.modalId" class="w-100" @input="makeSlugId"/>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">POSITIIN</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.position" :options="offcanvasPositions" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <div v-if="elemDetails.data.position == 'offcanvas-start' || elemDetails.data.position == 'offcanvas-end'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">OFFCANVAS SIZE</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.size" :options="modalSizes" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                </div>
            </div>

        </div>

        <div v-if="elemDetails.data.position == 'offcanvas-top' || elemDetails.data.position == 'offcanvas-bottom'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">CONTENT FULL WIDTH</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.contentAreaFull" />
                </div>
            </div>

        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">OFFCANVAS TITLE</label>
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
    type:'offcanvas_window',
    render_blade:true,
    blade:'offcanvas-window',
    data:{
        name:"OFFCANVAS",
        modalId:"",
        prevHtml:"",
        elemHtml:"",
        size:"",
        title:"",
        position:"offcanvas-start",
        contentAreaFull:false,
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
        label:"Large",
        value:"offcanvas-size-lg"
    },
    {
        label:"X Large",
        value:"offcanvas-size-xl"
    },
    {
        label:"XX Large",
        value:"offcanvas-size-xxl"
    }
];

let offcanvasPositions = [
    {
        label:"Left",
        value:"offcanvas-start"
    },
    {
        label:"Right",
        value:"offcanvas-end"
    },
    {
        label:"Top",
        value:"offcanvas-top"
    },
    {
        label:"Bottom",
        value:"offcanvas-bottom"
    }
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

const makeSlugId = () => {
    let sluggyModalId = slugify(elemDetails.value.data.modalId);
    elemDetails.value.data.modalId = sluggyModalId;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.modalId == "" ){
            resolve(false);
        }

        let prev_html = '<b>OFFCANVAS ID: </b>'+elemDetails.value.data.modalId;

        elemDetails.value.data.prevHtml = prev_html;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    } else {
        alert("Offcanvas ID zorunludur.!");
    }
    
    
}


</script>