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

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.buttonOptions.size" :options="buttonOptions.size" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">NEW WINDOW</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.buttonOptions.newWindow" />
            </div>
        </div>

        <Divider />
        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Ek SEÇENEK LINK</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.linkAttribute" showClear :options="attributeList" optionLabel="name" class="w-100"/>
            </div>
        </div>

        <div v-if="elemDetails.data.linkAttribute">
            <Divider/>
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">LINK ATTR FANCYBOX</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.linkAttributeFancyBox" />
                </div>
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

import {ref, onBeforeMount} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import {buttonOptions} from "./design-elements-data.js";
import {bootstrapIcons} from "./bootstrap-icons.js";


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'layout_read_more_button',
    layout:true,
    data:{
        name:"READ MORE BUTTON",
        prevHtml:"",
        elemHtml:"",
        text:"",
        icon:"",
        iconPosition:"left",
        linkAttribute:null,
        linkAttributeFancyBox:false,
        buttonOptions:{
            type:"btn-default",
            size:"",
            newWindow:false,
        },
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

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("a");
        
        elemDiv.classList.add("btn");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

        if( elemDetails.value.data.buttonOptions.newWindow){
            elemDiv.target = '_blank';
        }

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
        if( elemDetails.value.data.icon != null && elemDetails.value.data.icon != "" && elemDetails.value.data.iconPosition == "left" ){
            buttonText += '<i class="bi bi-'+elemDetails.value.data.icon+' pe-2"></i>';
        }

        buttonText += elemDetails.value.data.text;

        if( elemDetails.value.data.icon != null && elemDetails.value.data.icon != "" && elemDetails.value.data.iconPosition == "right" ){
            buttonText += '<i class="bi bi-'+elemDetails.value.data.icon+' ps-2"></i>';
        }

        elemDiv.innerHTML = buttonText;
        elemDiv.classList.add("stretched-link");
        elemDiv.href = "--LINK--";

        if( elemDetails.value.data.linkAttributeFancyBox && elemDetails.value.data.linkAttributeFancyBox === true ){
            elemDiv.setAttribute('data-fancybox',elemDetails.value.id);
        }

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = '<b>DETAYLI BİLGİ BUTONU</b>';
        elemDetails.value.data.elemHtml = '<div>'+htmlDiv.innerHTML+'</div>';

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