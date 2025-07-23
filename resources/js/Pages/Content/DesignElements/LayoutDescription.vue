<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement"/>

    </div>

</template>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
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
    type:'layout_description',
    layout:true,
    data:{
        name:"CONTENT DESCRIPTION",
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
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

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

        elemDiv.innerHTML = 'DESCRIPTION';

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = '<b>SAYFA DETAYLI AÇIKLAMASI</b>';
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


</script>