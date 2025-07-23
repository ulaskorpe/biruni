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
                        <label class="">Position</label>
                        <Dropdown v-model="elemDetails.data.iconPosition" :options="iconPositions" class="w-100" />
                    </div>
                    <div class="col-6">
                        <label class="">Color</label>
                        <Dropdown v-model="elemDetails.data.iconColor" :options="textColors" optionLabel="label" optionValue="value" class="w-100" />
                    </div>
                    <div class="col-6">
                        <label class="">Size</label>
                        <Dropdown v-model="elemDetails.data.iconSize" :options="displays" class="w-100" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE TEXT</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.cardTitle" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE COLOR</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.cardTitleColor" :options="textColors" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DESCRIPTION</label>
            <div class="col-md-9">
                <Textarea autoResize rows="1" cols="30" class="w-100" v-model="elemDetails.data.cardDescription" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DESCRIPTION COLOR</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.cardDescriptionColor" :options="textColors" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TEXT ALIGN</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.textAlign" :options="textAligns" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD BG COLOR</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.cardBgColor" :options="bgColors" showClear optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD BORDERED</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.cardBorder" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD SHADOW</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.cardShadow" :options="shadows" showClear class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">BUTTON LINK</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.buttonLink" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">BUTTON TEXT</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.buttonText" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">BUTTON TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.buttonOptions.type" :options="buttonOptions.type" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">BUTTON SIZE</label>
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
import InputSwitch from "primevue/inputswitch";
import Textarea from "primevue/textarea";
import Dropdown from "primevue/dropdown";
import RadioButton from 'primevue/radiobutton';
import BaseDesignOptions from "./BaseDesignOptions";
import {buttonOptions,textColors,bgColors} from "./design-elements-data.js";
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
    type:'iconcard',
    data:{
        name:"CARD WITH ICON",
        prevHtml:"",
        elemHtml:"",
        cardTitle:"",
        cardTitleColor:"text-default",
        cardDescription:"",
        cardDescriptionColor:"text-default",
        cardBorder:false,
        cardShadow:"",
        cardBgColor:"",
        textAlign:"text-center",
        icon:"",
        iconPosition:"top",
        iconColor:"text-default",
        iconSize:"display-6",
        buttonLink:"",
        buttonText:"",
        buttonOptions:{
            type:"btn-default",
            size:"",
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

let iconPositions = ["top","left"];
let textAligns = ["text-center","text-start"];
let shadows = ["","shadow-sm","shadow","shadow-lg"];
let displays = ["display-1","display-2","display-3","display-4","display-5","display-6","fs-1","fs-2","fs-3","fs-4","fs-5","fs-6"];

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
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
        const cardBody = document.createElement("div");
        const cardBodyDiv = document.createElement("div");
        const icon = document.createElement("i");

        elemDiv.classList.add("card");
        cardBody.classList.add("card-body");

        if( !elemDetails.value.data.cardBgColor || elemDetails.value.data.cardBgColor == "" ){
            cardBody.classList.add("p-0");
        }

        if( !elemDetails.value.data.cardBorder ){
            elemDiv.classList.add("border-0");
        }

        if( elemDetails.value.data.cardShadow && elemDetails.value.data.cardShadow != "" ){
            elemDiv.classList.add(elemDetails.value.data.cardShadow);
        }
        
        if( elemDetails.value.data.cardBgColor && elemDetails.value.data.cardBgColor != "" ){
            elemDiv.classList.add(elemDetails.value.data.cardBgColor);
        }

        /* spesifik padding secilerek yapilsin
        if( !elemDetails.value.data.cardBorder && ( !elemDetails.value.data.cardShadow || elemDetails.value.data.cardShadow == "" )&& ( !elemDetails.value.data.cardBgColor || elemDetails.value.data.cardBgColor == "" ) ){
            cardBody.classList.add("p-0");
        }
        */

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

        icon.classList.add("bi","bi-"+elemDetails.value.data.icon,elemDetails.value.data.iconColor,elemDetails.value.data.iconSize);
        if( elemDetails.value.data.iconPosition == 'left' ){

            cardBodyDiv.classList.add("hstack","align-items-start","gap-3","h-100");
            icon.classList.add("lh-1");

        } else {

            cardBodyDiv.classList.add("vstack","gap-3","h-100");

        }

        cardBodyDiv.classList.add(elemDetails.value.data.textAlign);

        cardBodyDiv.appendChild(icon);

        const cardBodyDivContent = document.createElement("div");
        cardBodyDivContent.classList.add("vstack","gap-2","h-100");

        if( elemDetails.value.data.cardTitle != "" ){
            const title = document.createElement("h3");
            title.classList.add("mb-0","lead-responsive",elemDetails.value.data.cardTitleColor);
            title.innerHTML = elemDetails.value.data.cardTitle;
            cardBodyDivContent.appendChild(title);
        }

        if( elemDetails.value.data.cardDescription != "" ){
            const description = document.createElement("p");
            description.classList.add("mb-0",elemDetails.value.data.cardDescriptionColor,"p-responsive");
            description.innerHTML = elemDetails.value.data.cardDescription;
            cardBodyDivContent.appendChild(description);
        }

        if( elemDetails.value.data.buttonLink && elemDetails.value.data.buttonLink != "" ){
            const buttonDiv = document.createElement("div");
            buttonDiv.classList.add("pt-3","mt-auto");
            const button = document.createElement("a");
            button.classList.add("btn",elemDetails.value.data.buttonOptions.type,'stretched-link');
            if( elemDetails.value.data.buttonOptions.size && elemDetails.value.data.buttonOptions.size != "" ){
                button.classList.add(elemDetails.value.data.buttonOptions.size);
            }
            button.href = elemDetails.value.data.buttonLink;
            button.innerHTML = elemDetails.value.data.buttonText;
            buttonDiv.appendChild(button);
            cardBodyDivContent.appendChild(buttonDiv);
        }
        
        cardBodyDiv.appendChild(cardBodyDivContent);
        cardBody.appendChild(cardBodyDiv);
        elemDiv.appendChild(cardBody);
        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = htmlDiv.innerHTML.replace('stretched-link','');
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


</script>