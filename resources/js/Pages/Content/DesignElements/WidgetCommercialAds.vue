<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>


        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">COMMERCIAL AD GROUP</label>
            <div class="col-md-9">
                <MultiSelect v-model="elemDetails.data.commercial_ad_areas" :options="commercial_ad_areas" optionLabel="name" optionValue="id" placeholder="Select" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ALL ITEMS</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.all_items" />
            </div>
        </div>

        <Divider />

        <div v-if="!elemDetails.data.all_items">
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">ITEMS COUNT</label>
                <div class="col-md-9">
                    <InputText v-model.number="elemDetails.data.itemCount" class="w-100" />
                    <Slider v-model="elemDetails.data.itemCount" class="w-100" :min="1" :max="100"/>
                </div>
            </div>

            <Divider />
        </div>

        <div v-if="elemDetails.data.commercial_ad_areas.length > 0">
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">INCLUDES</label>
                <div class="col-md-9">
                    <MultiSelect v-model="elemDetails.data.includes" showClear filter :options="commercial_ads.filter(c => elemDetails.data.commercial_ad_areas.includes(c.commercial_ad_area_id))" optionLabel="name" optionValue="id" placeholder="Select Contents" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">EXCLUDES</label>
                <div class="col-md-9">
                    <MultiSelect v-model="elemDetails.data.excludes" showClear filter :options="commercial_ads.filter(c => elemDetails.data.commercial_ad_areas.includes(c.commercial_ad_area_id))" optionLabel="name" optionValue="id" placeholder="Select Contents" class="w-100" />
                </div>
            </div>

            <Divider />
        </div>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.type" :options="galleryTypes" class="w-100" />
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

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">STAGE PADDING</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.stagepadding" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">CENTER SLIDES</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.center" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">LOOP</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.loop" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">AUTOPLAY</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.autoplay" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.autoplay">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">DELAY</label>
                <div class="col-md-9">
                    <InputNumber v-model="elemDetails.data.autoplayDelay" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.autoplay">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">AUTOPLAY STOP ON INT.</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.autoplayStopOnHover" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">SPACE BETWEEN</label>
                <div class="col-md-9">
                    <InputNumber v-model="elemDetails.data.spaceBetween" />
                </div>
            </div>
        </div>

        <Divider />

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
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
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
    type:'commercial_ads',
    widget:true,
    data:{
        name:"Reklam Listesi",
        prevHtml:"",
        elemHtml:"",
        commercial_ad_areas:[],
        includes:[],
        excludes:[],
        all_items:false,
        itemCount:6,
        type:"grid",
        orderBy:{
            label:"Default (ID DESC)",
            value:"id DESC"
        },
        pagination:true,
        navigation:false,
        stagepadding:false,
        center:false,
        loop:false,
        autoplay:false,
        autoplayDelay:5000,
        autoplayStopOnHover:false,
        spaceBetween:15,
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


let galleryTypes = ['grid','carousel'];

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const commercial_ad_areas = ref([]);
const commercial_ads = ref([]);

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.type == 'carousel' ) {

            const swiperOptionsData = {};

            if( elemDetails.value.data.pagination === true ){

                swiperOptionsData.pagination = {
                    el: ".swiper-pagination",
                    clickable:true,
                    dynamicBullets:true
                };

            }

            if( elemDetails.value.data.navigation === true ){

                swiperOptionsData.navigation = {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                };

            }

            let stagePadding = {
                default:0,
                md:0,
                lg:0,
                xl:0
            };

            if( elemDetails.value.data.stagepadding === true ){

                stagePadding = {
                    default:0.2,
                    md:0.3,
                    lg:0.4,
                    xl:0.5
                };

            }

            if( elemDetails.value.data.center ){
                swiperOptionsData.centeredSlides = true;
            }

            if( elemDetails.value.data.loop ){
                swiperOptionsData.loop = true; //loop yerine rewind daha iyi
            }

            if( elemDetails.value.data.autoplay ){
                swiperOptionsData.autoplay = {
                    delay: elemDetails.value.data.autoplayDelay,
                    disableOnInteraction: elemDetails.value.data.autoplayStopOnHover,
                };
            }

            swiperOptionsData.slidesPerView = elemDetails.value.data.columnCounts.sm + stagePadding.default;
            swiperOptionsData.spaceBetween = elemDetails.value.data.spaceBetween;

            swiperOptionsData.breakpoints = {
                400: {
                    slidesPerView: elemDetails.value.data.columnCounts.sm + stagePadding.default,
                },
                768: {
                    slidesPerView: elemDetails.value.data.columnCounts.md + stagePadding.md,
                },
                998: {
                    slidesPerView: elemDetails.value.data.columnCounts.lg + stagePadding.lg,
                },
                1200: {
                    slidesPerView: elemDetails.value.data.columnCounts.xl + stagePadding.xl,
                },
                1400: {
                    slidesPerView: elemDetails.value.data.columnCounts.xl + stagePadding.xl,
                },
            };

            elemDetails.value.data.swiperOptions = JSON.stringify(swiperOptionsData);
        
        }

        elemDetails.value.data.prevHtml = 'Reklam Listesi Widget';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}

onMounted(() => {
   
   fetch(route('commercial-ad-areas.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
       commercial_ad_areas.value = json;
   });

   fetch(route('commercial-ads.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
       commercial_ads.value = json;
   });
   
});

</script>