<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">MENU</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.menu" :options="menus" optionLabel="name" class="w-100" />
            </div>
        </div>

        <Divider/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DIRECTION</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.direction" :options="['vertical','horizontal']" class="w-100" />
            </div>
        </div>

        <div v-if="elemDetails.data.direction == 'vertical'">
            <Divider/>

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">ACCORDEON</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.accordeon" />
                </div>
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
    type:'menu',
    widget:true,
    data:{
        name:"menu",
        prevHtml:"",
        elemHtml:"",
        menu:null,
        direction:"vertical",
        accordeon:false,
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
const menus = ref([]);

const getMenus = () => {

    fetch(route('menus.index'),{
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
        }
    }).then(function(response){
        return response.json();
    }).then((json) => {
        menus.value = json;
    })

}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( !elemDetails.value.data.menu ){
            resolve(false);
        }

        elemDetails.value.data.prevHtml = 'Menu: <b>'+elemDetails.value.data.menu.name+'</b>';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    } else {
        alert("Menu seçilmedi!");
    }
}

onMounted(() => {
    getMenus();
});

</script>