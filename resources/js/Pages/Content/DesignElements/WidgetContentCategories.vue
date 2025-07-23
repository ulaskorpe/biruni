<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SELECT CATEGORIES</label>
            <div class="col-md-9">
                <MultiSelect v-model="elemDetails.data.categories" :options="content_types" optionGroupLabel="name" optionLabel="name" optionValue="id" optionGroupChildren="categories" placeholder="Select Categories" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.type" :options="galleryTypes" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.card_type" :options="cardTypes" class="w-100" />
            </div>
        </div>

        <OrderByOptions :order-by="elemDetails.data.orderBy"/>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">PAGINATION</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.pagination" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">NAVIGATION</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.navigation" />
                </div>
            </div>
        </div>

        <ColumnCounts :column-counts="elemDetails.data.columnCounts"/>

        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement"/>

    </div>

</template>

<script setup>

import {ref,onMounted} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import MultiSelect from "primevue/multiselect";
import BaseDesignOptions from "./BaseDesignOptions";
import ColumnCounts from "./ColumnCounts";
import OrderByOptions from "./OrderByOptions";
import Slider from 'primevue/slider';


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'content_categories',
    widget:true,
    data:{
        name:"İçerik Kategorileri",
        prevHtml:"",
        elemHtml:"",
        categories:[],
        itemCount:6,
        type:"grid",
        card_type:"type-1",
        orderBy:{
            label:"Default (ID DESC)",
            value:"id DESC"
        },
        pagination:true,
        navigation:false,
        swiperOptions:"",
        columnCounts:{
            sm:1,
            md:1,
            lg:1,
            xl:1
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


let galleryTypes = ['grid','carousel','horizontal-accordeon'];
let cardTypes = ['type-1','type-2','type-3'];

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const content_types = ref(null);

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.type == 'carousel' ) {

            const swiperOptionsData = {
                lazy: true,
            };

            if( elemDetails.value.data.pagination ){

                swiperOptionsData.pagination = {
                    el: ".swiper-pagination",
                    clickable:true
                };

            }

            if( elemDetails.value.data.navigation ){

                swiperOptionsData.navigation = {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                };

            }

            swiperOptionsData.slidesPerView = 1;
            swiperOptionsData.spaceBetween = 15;

            swiperOptionsData.breakpoints = {
                400: {
                    slidesPerView: elemDetails.value.data.columnCounts.sm,
                },
                768: {
                    slidesPerView: elemDetails.value.data.columnCounts.md,
                },
                998: {
                    slidesPerView: elemDetails.value.data.columnCounts.lg,
                },
                1200: {
                    slidesPerView:  elemDetails.value.data.columnCounts.xl,
                }
            };

            elemDetails.value.data.swiperOptions = JSON.stringify(swiperOptionsData);
        
        }

        elemDetails.value.data.prevHtml = 'İçerik Kategorileri Widget';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}

onMounted(() => {
   
    fetch(route('content-types.index'),{
        headers:{
            'Accept':'application/json'
        }
    }).then(function(response) {
        return response.json();
    }).then((json) => {
        content_types.value = json;
    });
    
});

</script>