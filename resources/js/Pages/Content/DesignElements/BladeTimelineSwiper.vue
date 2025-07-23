<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Title</label>
            <div class="col-md-9">
                <Textarea v-model="elemDetails.data.sliderTitle" rows="2" cols="30" class="w-100" />
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
                                <Panel toggleable collapsed :header="acc.accTitle" class="mb-2">

                                    <template #icons>
                                        <button class="p-panel-header-icon p-link drag-acc-item me-2">
                                            <span class="bi bi-arrow-down-up"></span>
                                        </button>
                                        <button class="p-panel-header-icon p-link me-2" @click="elemDetails.data.accItems.splice(a,1)">
                                            <span class="bi bi-trash"></span>
                                        </button>
                                    </template>

                                    <div class="d-flex flex-row align-items-center mb-6">
                                        <img :src="acc.accMedia.preview_url" v-if="acc.accMedia" class="img-thumbnail" width="100"/>
                                        <PopupMediaLibrary v-if="!acc.accMedia" @click="accIndex = a" :on-select="setAccMedia" :form-model="acc.accMedia" :button-text="'Görsel Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                        <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" @click="acc.accMedia = null" v-if="acc.accMedia">
                                            <i class="bi bi-x fs-3"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex flex-column mb-6">
                                        <label class="form-label">TITLE</label>
                                        <InputText v-model="acc.accTitle" class="w-100" />
                                    </div>

                                    <div class="d-flex flex-column mb-6">
                                        <label class="form-label">DESCRIPTION</label>
                                        <Textarea v-model="acc.accDescription" rows="2" cols="30" class="w-100" />
                                    </div>
                                </Panel>
                            </div>
                        </template>
                    </draggable>
                </div>
                <Button label="Add Item" size="small" @click="addAccItem"/>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMAGE SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.conversion" :options="conversions" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LIGHTBOX</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.lightbox" />
            </div>
        </div>

        <div>
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">PAGINATION</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.pagination" />
                </div>
            </div>
        </div>

        <div>
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">NAVIGATION</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.navigation" />
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
import Panel from 'primevue/panel';
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import Textarea from 'primevue/textarea';
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";
import draggable from 'vuedraggable';

const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

const editor = ref(null);

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'timeline_swiper',
    render_blade:true,
    blade:'timeline-swiper',
    data:{
        name:"TIMELINE SLIDER",
        accItems:[],
        sliderTitle:"",
        prevHtml:"",
        elemHtml:"",
        lightbox:false,
        conversion:"",
        pagination:true,
        navigation:false,
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

let conversions = [
    {
        label:"Default Size",
        value:""
    },
    {
        label:"Optimize",
        value:"op_url"
    },
    {
        label:"Thumbnail",
        value:"th_url"
    },
    {
        label:"992x500",
        value:"992x500_url"
    },
    {
        label:"500x500",
        value:"500x500_url"
    },
    {
        label:"300x300",
        value:"300x300_url"
    },
    {
        label:"1200x1200",
        value:"1200x1200_url"
    },
    {
        label:"100x100",
        value:"100x100_url"
    }
]

let newItem = {
    accMedia:null,
    accTitle:"Card",
    accDescription:""
}

const accIndex = ref(null);

const addAccItem = () => {
    elemDetails.value.data.accItems.push(JSON.parse(JSON.stringify(newItem)));
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

const setAccMedia = (media) => {
    elemDetails.value.data.accItems[accIndex.value].accMedia = media;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.accItems.length == 0 ){
            resolve(false);
        }

        let prev_html = '<b>Timeline slider</b>';

        elemDetails.value.data.prevHtml = prev_html;

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