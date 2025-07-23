<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SLIDER</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.slider" :options="sliders" optionLabel="name" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">HEIGHT</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.height" :options="heightClasses" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SLIDE TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.slideType" :options="['default','type-1','type-2','type-3']" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">PAGINATION</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.pagination" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CREATIVE EFFECT</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.creative" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">NAVIGATION</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.navigation" />
            </div>
        </div>

        <ColumnCounts :column-counts="elemDetails.data.columnCounts"/>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SLIDES BETWEEN</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.spaceBetween" :options="[0,15,30,50,75,100]" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LOOP</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.loop" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CENTER SLIDES</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.centeredSlides" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">NEXT PREV VISIBLE AREA</label>
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon">SM</span>
                            <InputNumber v-model="elemDetails.data.nextPrevVisibleArea.sm" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon">MD</span>
                            <InputNumber v-model="elemDetails.data.nextPrevVisibleArea.md" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon">LG</span>
                            <InputNumber v-model="elemDetails.data.nextPrevVisibleArea.lg" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon">XL</span>
                            <InputNumber v-model="elemDetails.data.nextPrevVisibleArea.xl" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                        </div>
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

import {ref,onMounted} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputSwitch from "primevue/inputswitch";
import InputNumber from "primevue/inputnumber";
import ColumnCounts from "./ColumnCounts";
import BaseDesignOptions from "./BaseDesignOptions";
import {heightClasses} from "./design-elements-data.js";


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'slider',
    widget:true,
    data:{
        name:"SLIDER",
        prevHtml:"",
        elemHtml:"",
        slider:null,
        pagination:true,
        creative:false,
        navigation:false,
        swiperOptions:"",
        height:"h-300px",
        slideType:"default",
        columnCounts:{
            sm:1,
            md:1,
            lg:1,
            xl:1
        },
        nextPrevVisibleArea:{
            sm:0,
            md:0,
            lg:0,
            xl:0
        },
        spaceBetween:0,
        centeredSlides:true,
        loop:true,
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

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}
const sliders = ref([]);

const getSliders = () => {

    fetch(route('sliders.index'),{
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
        }
    }).then(function(response){
        return response.json();
    }).then((json) => {
        sliders.value = json;
    })

}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( !elemDetails.value.data.slider ){
            resolve(false);
        }

        const swiperOptionsData = {
            //lazy: true, artik kullanilmiyormus.
            grabCursor: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
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

        if( elemDetails.value.data.creative ){

            swiperOptionsData.grabCursor = true;
            swiperOptionsData.effect = "creative";
            swiperOptionsData.creativeEffect = {
                prev: {
                shadow: true,
                translate: ["-20%", 0, -1],
                },
                next: {
                translate: ["100%", 0, 0],
                },
            };

        }

        swiperOptionsData.loop = elemDetails.value.data.loop;

        if( elemDetails.value.data.centeredSlides ){
            swiperOptionsData.centeredSlides = true;
        }

        swiperOptionsData.slidesPerView = elemDetails.value.data.columnCounts.xl + elemDetails.value.data.nextPrevVisibleArea.xl;
        swiperOptionsData.spaceBetween = elemDetails.value.data.spaceBetween;

        swiperOptionsData.breakpoints = {
            400: {
                slidesPerView: elemDetails.value.data.columnCounts.sm + elemDetails.value.data.nextPrevVisibleArea.sm,
            },
            768: {
                slidesPerView: elemDetails.value.data.columnCounts.md + elemDetails.value.data.nextPrevVisibleArea.md,
            },
            998: {
                slidesPerView: elemDetails.value.data.columnCounts.lg + elemDetails.value.data.nextPrevVisibleArea.lg,
            },
            1200: {
                slidesPerView:  elemDetails.value.data.columnCounts.xl + elemDetails.value.data.nextPrevVisibleArea.xl,
            }
        };

        elemDetails.value.data.swiperOptions = JSON.stringify(swiperOptionsData);

        elemDetails.value.data.prevHtml = 'Slider: <b>'+elemDetails.value.data.slider.name+'</b>';

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    } else {
        alert("Slider seçilmedi!");
    }
}

onMounted(() => {
    getSliders();
});

</script>