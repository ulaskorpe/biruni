<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ICON</label>
            <div class="col-md-9">

                <div class="row g-4">
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
                        <label class="">Color</label>
                        <Dropdown v-model="elemDetails.data.iconColor" :options="textColors" optionLabel="label" optionValue="value" class="w-100" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ITEMS</label>
            <div class="col-md-9">
                <div class="mb-5" v-if="elemDetails.data.accItems.length > 0">
                    <draggable 
                        v-model="elemDetails.data.accItems" 
                        group="accItem" 
                        @start="drag=true" 
                        @end="drag=false" 
                        handle=".drag-acc-item" 
                        item-key="id"
                    >
                        <template #item="{element:acc,index:a}">
                            <div>

                                <Panel toggleable collapsed :header="`Item-${a+1}`" class="mb-2">
                                    <template #icons>
                                        <button class="p-panel-header-icon p-link drag-acc-item me-2">
                                            <span class="bi bi-arrow-down-up"></span>
                                        </button>
                                        <button class="p-panel-header-icon p-link me-2" @click="elemDetails.data.accItems.splice(a,1)">
                                            <span class="bi bi-trash"></span>
                                        </button>
                                    </template>
                                    <div class="d-flex flex-column mb-10">
                                        <TextEditor v-model="acc.accContent" />
                                    </div>
                                </Panel>

                            </div>
                        </template>
                    </draggable>
                </div>
                <Button label="Add Item" size="small" @click="addAccItem"/>
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
import Panel from "primevue/panel";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import TextEditor from "../../../Components/TextEditor";
import draggable from 'vuedraggable';
import BaseDesignOptions from "./BaseDesignOptions";
import {buttonOptions,textColors} from "./design-elements-data.js";
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
    type:'icon_list',
    data:{
        name:"ICON LIST",
        prevHtml:"",
        elemHtml:"",
        icon:"",
        iconColor:"text-default",
        accItems:[],
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

let newItem = {
    accContent:""
}

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const addAccItem = () => {
    elemDetails.value.data.accItems.push(JSON.parse(JSON.stringify(newItem)));
}

const prepareElement = async () => {

let promise = new Promise(function(resolve, reject) {

    const htmlDiv = document.createElement("div");
    const elemDiv = document.createElement("ul");

    elemDiv.classList.add("list-unstyled","icon-list");
    elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

    if(elemDetails.value.data.baseDesignOptions.class){
        let classes = elemDetails.value.data.baseDesignOptions.class.split(' ');
        classes.forEach(cl => {
            if( cl && cl != ""){
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

    elemDetails.value.data.accItems.forEach((item,index) => {
        
        let liElem = document.createElement("li");

        liElem.innerHTML = '<i class="bi bi-'+elemDetails.value.data.icon+' '+elemDetails.value.data.iconColor+'"></i>'+item.accContent;

        elemDiv.appendChild(liElem);

    });

    htmlDiv.appendChild(elemDiv);

    elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
    elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

    resolve(true);
});

const isElementReady = await promise;
if(isElementReady){
    props.onDone(elemDetails.value);
} else {
    alert("Görsel seçilmedi!");
}
}


</script>