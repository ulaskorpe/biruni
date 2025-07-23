<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ŞUBE</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.sube.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.sube.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.sube.label" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />
        
        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SEGMENT</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.segments.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.segments.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.segments.label" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ÜRÜN TİPİ</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.product_types.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.product_types.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.product_types.label" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">KATEGORİLER</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.categories.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.categories.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.categories.label" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ÜCRET</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.price.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.price.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.price.label" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ÜRÜN ÖZELLİKLERİ</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.attributes.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.attributes.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.attributes.label" />
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ETKİNLİK TARİHİ</label>
            <div class="col-md-9">
                <div class="hstack align-items-center gap-4">
                    <InputSwitch v-model="elemDetails.data.filters.event_date.active" />
                    <div class="hstack gap-2 align-items-center" v-if="elemDetails.data.filters.event_date.active">
                        <span class="fw-bold">Label: </span>
                        <InputText v-model="elemDetails.data.filters.event_date.label" />
                    </div>
                </div>
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
import InputText from "primevue/inputtext";
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
    type:'layout_filters',
    layout:true,
    data:{
        name:"ÜRÜN FİLTRELERİ",
        prevHtml:"",
        elemHtml:"",
        filters:{
            sube:{
                active:false,
                label:"ŞUBE"
            },
            segments:{
                active:false,
                label:"SEGMENT"
            },
            product_types:{
                active:false,
                label:"ÜRÜN TİPİ"
            },
            categories:{
                active:false,
                label:"KATEGORİLER"
            },
            price:{
                active:false,
                label:"ÜCRET"
            },
            attributes:{
                active:false,
                label:"ÖZELLİKLER"
            },
            event_date:{
                active:false,
                label:"ETKİNLİK TARİHİ"
            }
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

        elemDetails.value.data.prevHtml = '<b>ÜRÜN FİLTRELEME SEÇENEKLERİ</b>';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}


</script>