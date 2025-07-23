<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">FORM</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.form" :options="forms" optionLabel="name" class="w-100" />
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
    type:'form',
    widget:true,
    data:{
        name:"FORM",
        prevHtml:"",
        elemHtml:"",
        form:null,
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
const forms = ref([]);

const getforms = () => {

    fetch(route('forms.index'),{
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
        }
    }).then(function(response){
        return response.json();
    }).then((json) => {
        forms.value = json;
    })

}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( !elemDetails.value.data.form ){
            resolve(false);
        }
        elemDetails.value.data.prevHtml = 'Form: <b>'+elemDetails.value.data.form.name+'</b>';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    } else {
        alert("form seçilmedi!");
    }
}

onMounted(() => {
    getforms();
});

</script>