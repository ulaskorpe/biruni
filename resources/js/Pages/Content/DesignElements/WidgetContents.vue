<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">WIDGET ID</label>
            <div class="col-md-9">
                <InputText v-model.number="elemDetails.data.widgetId" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ALL CONTENT TYPES</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.all_content_types" />
            </div>
        </div>

        <Divider />

        <div v-if="!elemDetails.data.all_content_types">
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">CONTENT TYPES</label>
                <div class="col-md-9">
                    <MultiSelect v-model="elemDetails.data.content_types" :options="content_types" optionLabel="name" optionValue="id" placeholder="Select content Types" class="w-100" />
                </div>
            </div>

            <Divider />
        </div>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CATEGORIES</label>
            <div class="col-md-9">
                <MultiSelect v-model="elemDetails.data.categories" :options="content_types" optionGroupLabel="name" optionLabel="name" optionValue="id" optionGroupChildren="categories" placeholder="Select Categories" class="w-100" />
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

        <div v-if="elemDetails.data.content_types.length > 0">
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">INCLUDES</label>
                <div class="col-md-9">
                    <MultiSelect v-model="elemDetails.data.includes" showClear filter :options="content_types.filter(c => elemDetails.data.content_types.includes(c.id))" optionGroupLabel="name" optionLabel="name" optionValue="id" optionGroupChildren="contents" placeholder="Select Contents" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">EXCLUDES</label>
                <div class="col-md-9">
                    <MultiSelect v-model="elemDetails.data.excludes" showClear filter :options="content_types.filter(c => elemDetails.data.content_types.includes(c.id))" optionGroupLabel="name" optionLabel="name" optionValue="id" optionGroupChildren="contents" placeholder="Select Contents" class="w-100" />
                </div>
            </div>

            <Divider />
        </div>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ONLY HAS DEPENDING CONTENT</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.only_has_depending_content" />
            </div>
        </div>

        <Divider />

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

            <div v-if="elemDetails.data.navigation">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-3 fw-bold text-uppercase">NAVIGATION POSITION</label>
                    <div class="col-md-9">
                        <Dropdown v-model="elemDetails.data.navigationPosition" :options="['navigation-default','navigation-bottom-left','navigation-bottom-right','navigation-top-right']" class="w-100" />
                    </div>
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

        <div v-if="elemDetails.data.type != 'accordeon'">

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">CARD TYPE</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.cardType" :options="cardTypes" class="w-100" />
                </div>
            </div>

            <div v-if="elemDetails.data.cardType == 'custom'">
                <Divider />
                <div class="row align-items-center">
                    <label class="col-md-3 fw-bold text-uppercase">CUSTOM LAYOUT</label>
                    <div class="col-md-9">
                        <Dropdown v-model="elemDetails.data.customCardLayout" :options="card_layouts" optionLabel="name" optionValue="id" class="w-100" placeholder="Select card layout"/>
                    </div>
                </div>
            </div>

            <ColumnCounts :column-counts="elemDetails.data.columnCounts"/>

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
    type:'contents',
    widget:true,
    data:{
        widgetId:"",
        name:"İçerik Listesi",
        prevHtml:"",
        elemHtml:"",
        all_content_types:true,
        content_types:[],
        categories:[],
        includes:[],
        excludes:[],
        all_items:false,
        only_has_depending_content:false,
        itemCount:6,
        type:"grid",
        orderBy:{
            label:"Default (ID DESC)",
            value:"id DESC"
        },
        pagination:true,
        navigation:false,
        navigationPosition:"navigation-default",
        stagepadding:false,
        center:false,
        loop:false,
        autoplay:false,
        autoplayDelay:5000,
        autoplayStopOnHover:false,
        spaceBetween:15,
        swiperOptions:"",
        cardType:"default",
        customCardLayout:0,
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


let galleryTypes = ['grid','carousel','accordeon','horizontal-accordeon'];
let cardTypes = ['default','custom'];

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const content_types = ref([]);
const card_layouts = ref([]);

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

        elemDetails.value.data.prevHtml = 'İçerik Listesi Widget';

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

   fetch(route('card-layouts.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
       card_layouts.value = json;
   });
   
});

</script>