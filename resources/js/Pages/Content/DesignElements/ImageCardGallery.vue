<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

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

                                    <div class="vstack gap-3">

                                        <div class="d-flex flex-row align-items-center">
                                            <img :src="acc.accMedia.original_url" v-if="acc.accMedia" class="img-thumbnail" width="100"/>
                                            <PopupMediaLibrary v-if="!acc.accMedia" @click="accIndex = a" :on-select="setAccMedia" :form-model="acc.accMedia" :button-text="'Görsel Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                            <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" @click="acc.accMedia = null" v-if="acc.accMedia">
                                                <i class="bi bi-x fs-3"></i>
                                            </button>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <label class="form-label">TITLE</label>
                                            <InputText v-model="acc.accTitle" class="w-100" />
                                        </div>

                                        <div class="d-flex flex-column">
                                            <label class="form-label">DESCRIPTION</label>
                                            <Textarea v-model="acc.accDescription" rows="2" cols="30" class="w-100" />
                                        </div>

                                        <div class="row align-items-center">
                                            <label class="col-md-3 fw-bold text-uppercase">CARD EXTRA CLASSES</label>
                                            <div class="col-md-9">
                                                <InputText v-model="acc.cardExtraClassess" class="w-100" />
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <label class="col-md-3 fw-bold text-uppercase">CONTENT AREA EXTRA CLASSES</label>
                                            <div class="col-md-9">
                                                <InputText v-model="acc.contentAreaExtraClasses" class="w-100" />
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <label class="col-md-3 fw-bold text-uppercase">IMAGE EXTRA CLASSES</label>
                                            <div class="col-md-9">
                                                <InputText v-model="acc.imgExtraClasses" class="w-100" />
                                            </div>
                                        </div>

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
            <label class="col-md-3 fw-bold text-uppercase">CARD BG COLOR</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.cardBgColor" :options="bgColors" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD ROUNDED</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.cardRounded" :options="roundedsWithoutOverflow" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD NUMBERS</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.cardNumbers" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CARD PADDING</label>
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-up"></i></span>
                            <Dropdown v-model="elemDetails.data.cardPadding.top" :options="paddings.top" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                            <Dropdown v-model="elemDetails.data.cardPadding.right" :options="paddings.right" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                            <Dropdown v-model="elemDetails.data.cardPadding.bottom" :options="paddings.bottom" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                            <Dropdown v-model="elemDetails.data.cardPadding.left" :options="paddings.left" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>
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
            <label class="col-md-3 fw-bold text-uppercase">IMAGE POSITION</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imagePosition" :options="['top','left', 'bottom']" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMAGE BG COLOR</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imageBgColor" :options="bgColors" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMAGE ROUNDED</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imageRounded" :options="roundedsWithoutOverflow" optionLabel="label" optionValue="value" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TEXT ALIGN</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.textAlign" :options="['text-start','text-center']" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMAGE MAX WIDTH</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.imageMaxWidth" :options="minMaxWidths" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <div v-if="elemDetails.data.imagePosition == 'left'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">IMAGE ALIGNMENT</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.imageAlign" :options="['align-items-start','align-items-center']" class="w-100" />
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE COLOR</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.titleColor" :options="textColors" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE FONT WEIGHT</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.titleFontWeight" :options="fontWeights" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE DIVIDER</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.titleDivider" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE TAG</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.titleTag" :options="['div','p','h2','h3','h4','h5','h6']" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.titleSize" :options="displaySizes" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TYPE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.type" :options="galleryTypes" class="w-100" />
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'grid'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">MASONRY LAYOUT</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.masonry" />
                </div>
            </div>
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">ROW GUTTER</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.gutter" class="w-100" />
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LIGHTBOX</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.lightbox" />
            </div>
        </div>

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

            <Divider/>
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
        </div>

        <ColumnCounts :column-counts="elemDetails.data.columnCounts"/>

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
import InputNumber from "primevue/inputnumber";
import Textarea from 'primevue/textarea';
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import ColumnCounts from "./ColumnCounts";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";
import draggable from 'vuedraggable';
import {bgColors, textColors,fontWeights, roundedsWithoutOverflow, paddings, displaySizes} from "./design-elements-data.js";

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
    type:'card_gallery',
    data:{
        name:"IMAGE CARD GALLERY",
        accItems:[],
        prevHtml:"",
        elemHtml:"",
        lightbox:false,
        imagePosition:"top",
        imageMaxWidth:"",
        imageBgColor:"",
        imageRounded:"",
        textAlign:"text-start",
        imageAlign:"align-items-start",
        conversion:"",
        type:"grid",
        gutter:"g-3 g-xl-4",
        cardBgColor:"",
        cardRounded:"",
        cardPadding: {
            top: "",
            right: "",
            bottom: "",
            left: ""
        },
        cardNumbers:false,
        titleColor:"",
        titleFontWeight:"",
        titleDivider:false,
        titleTag:"div",
        titleSize:"h3",
        masonry:false,
        pagination:true,
        navigation:false,
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
];

let galleryTypes = ['grid','carousel'];

let minMaxWidths = [
    {
        label:"Default Size",
        value:""
    },
    {
        label:"25px",
        value:"min-w-25px mw-25px"
    },
    {
        label:"30px",
        value:"min-w-30px mw-30px"
    },
    {
        label:"35px",
        value:"min-w-35px mw-35px"
    },
    {
        label:"40px",
        value:"min-w-40px mw-40px"
    },
    {
        label:"50px",
        value:"min-w-50px mw-50px"
    },
    {
        label:"75px",
        value:"min-w-75px mw-75px"
    },
    {
        label:"100px",
        value:"min-w-100px mw-100px"
    },
    {
        label:"125px",
        value:"min-w-125px mw-125px"
    },
    {
        label:"150px",
        value:"min-w-150px mw-150px"
    },
    {
        label:"200px",
        value:"min-w-200px mw-200px"
    },
];

let newItem = {
    accMedia:null,
    accTitle:"Card",
    accDescription:"",
    cardExtraClassess:"",
    contentAreaExtraClasses:"",
    imgExtraClasses:"",
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

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

        if(elemDetails.value.data.type == 'grid'){
            elemDiv.classList.add('row');
            if(elemDetails.value.data.gutter){
                let gutterClasses = elemDetails.value.data.gutter.split(' ');
                gutterClasses.forEach(cl => {
                    if( cl &&  cl != ""){
                        elemDiv.classList.add(cl);
                    }
                });
            }
            elemDiv.classList.add('row-cols-'+elemDetails.value.data.columnCounts.sm);
            elemDiv.classList.add('row-cols-md-'+elemDetails.value.data.columnCounts.md);
            elemDiv.classList.add('row-cols-lg-'+elemDetails.value.data.columnCounts.lg);
            elemDiv.classList.add('row-cols-xl-'+elemDetails.value.data.columnCounts.xl);
            if (elemDetails.value.data.masonry) {
                elemDiv.setAttribute('data-masonry','{"percentPosition": true }')
            }
        } else {
            elemDiv.classList.add('ea-swiper','swiper','w-100');
        }


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


        if( elemDetails.value.data.type == 'grid' ){

            elemDetails.value.data.accItems.forEach((item,index) => {
            
                let colElem = document.createElement("div");
                let cardElem = document.createElement("div");
                colElem.classList.add('col');
                cardElem.classList.add('w-100');

                if( elemDetails.value.data.cardRounded && elemDetails.value.data.cardRounded != "" ){
                    cardElem.classList.add(elemDetails.value.data.cardRounded);
                }

                if( elemDetails.value.data.cardBgColor && elemDetails.value.data.cardBgColor != "" ){
                    cardElem.classList.add(elemDetails.value.data.cardBgColor);
                }

                if( elemDetails.value.data.textAlign && elemDetails.value.data.textAlign != "" ){
                    cardElem.classList.add(elemDetails.value.data.textAlign);
                }


                if(item.cardExtraClassess){
                    let classes = item.cardExtraClassess.split(' ');
                    classes.forEach(cl => {
                        if( cl &&  cl != ""){
                            cardElem.classList.add(cl);
                        }
                    });
                }

                Object.entries(elemDetails.value.data.cardPadding).forEach(([key, val]) => {
                    if(val && val != ""){
                        cardElem.classList.add(val);
                    }
                });


                if( elemDetails.value.data.cardNumbers ){
                    let numberDiv = document.createElement("div");
                    if( elemDetails.value.data.titleColor && elemDetails.value.data.titleColor != "" ){
                        numberDiv.classList.add(elemDetails.value.data.titleColor);
                    }
                    numberDiv.classList.add("card-number");
                    numberDiv.innerHTML = index + 1;
                    cardElem.appendChild(numberDiv);
                }


                if( elemDetails.value.data.imagePosition == 'left' ){

                    cardElem.classList.add("hstack","gap-3","h-100");

                    if( elemDetails.value.data.imageAlign && elemDetails.value.data.imageAlign != "" ){
                        cardElem.classList.add(elemDetails.value.data.imageAlign);
                    } else {
                        cardElem.classList.add("align-items-start");
                    }

                } else {

                    cardElem.classList.add("vstack","gap-3","h-100");

                    if( elemDetails.value.data.imagePosition == 'bottom' ){
                        cardElem.classList.add("flex-column-reverse");
                    }

                }

                let imgDivElem = document.createElement("div");
                let imgElem = document.createElement("img");
                imgDivElem.classList.add('overflow-hidden');
                imgElem.classList.add('img-fluid');
                imgElem.loading = "lazy";


                if (elemDetails.value.data.imageBgColor && elemDetails.value.data.imageBgColor != "") {
            
                    imgDivElem.classList.add("p-2",elemDetails.value.data.imageBgColor);

                }

                if (elemDetails.value.data.imageMaxWidth && elemDetails.value.data.imageMaxWidth != "") {
            
                    let minMaxClassesArr = elemDetails.value.data.imageMaxWidth.split(" ");
                    minMaxClassesArr.forEach(cls => {
                        imgDivElem.classList.add(cls);
                    });

                }

                if (elemDetails.value.data.textAlign && elemDetails.value.data.textAlign == "text-center") {
            
                    imgDivElem.classList.add("mx-auto");

                }

                if (elemDetails.value.data.imageRounded && elemDetails.value.data.imageRounded != "") {
                    
                    imgDivElem.classList.add("p-2",elemDetails.value.data.imageRounded);
                    imgElem.classList.add(elemDetails.value.data.imageRounded);

                }

                if(item.imgExtraClasses){
                    let classes = item.imgExtraClasses.split(' ');
                    classes.forEach(cl => {
                        if( cl &&  cl != ""){
                            imgDivElem.classList.add(cl);
                        }
                    });
                }

                let media = item.accMedia;

                if( media ){
                    if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" ){

                    imgElem.src = media.original_url;
                    imgElem.width = media.custom_properties.width;
                    imgElem.height = media.custom_properties.height;

                    } else {

                        imgElem.src = media.conversion_urls[elemDetails.value.data.conversion];

                        switch (elemDetails.value.data.conversion) {

                            case "op_url":
                            imgElem.width = 1300;
                            break;

                            case "th_url":
                            imgElem.width = 992;
                            break;

                            default:
                            let convArr = elemDetails.value.data.conversion.replace('_url','').split('x')
                            imgElem.width = convArr[0];
                            imgElem.height = convArr[1];
                            break;
                        }

                        if( elemDetails.value.data.conversion == 'op' ){
                            imgElem.width = 1300;
                        }
                    }

                    imgElem.alt = media.name;

                    if (elemDetails.value.data.lightbox) {
            
                        imgDivElem.setAttribute("data-fancybox",elemDetails.value.id);
                        imgDivElem.setAttribute("data-src",media.original_url);
                        imgDivElem.classList.add("cursor-pointer");

                    }

                    imgDivElem.appendChild(imgElem);
                    cardElem.appendChild(imgDivElem);
                    colElem.appendChild(cardElem);
                }

                let cardBodyDivContent = document.createElement("div");
                cardBodyDivContent.classList.add("d-flex","flex-column","gap-2");

                if(item.contentAreaExtraClasses){
                    let classes = item.contentAreaExtraClasses.split(' ');
                    classes.forEach(cl => {
                        if( cl &&  cl != ""){
                            cardBodyDivContent.classList.add(cl);
                        }
                    });
                }

                if(item.accTitle && item.accTitle != ""){
                    let titleElem = document.createElement(elemDetails.value.data.titleTag);
                    titleElem.classList.add(elemDetails.value.data.titleSize);
                    titleElem.classList.add("mb-0","lh-sm");

                    let dividerColor = "";

                    if( elemDetails.value.data.titleColor && elemDetails.value.data.titleColor != "" ){
                        titleElem.classList.add(elemDetails.value.data.titleColor);
                        dividerColor = "border-"+elemDetails.value.data.titleColor.split("-")[1];
                    }
                    if( elemDetails.value.data.titleFontWeight && elemDetails.value.data.titleFontWeight != "" ){
                        titleElem.classList.add(elemDetails.value.data.titleFontWeight);
                    }

                    titleElem.innerHTML = item.accTitle;
                    cardBodyDivContent.appendChild(titleElem);

                    if( elemDetails.value.data.titleDivider ){
                        let divider = document.createElement("hr");
                        divider.classList.add("my-1","opacity-100","border-top");
                        if( dividerColor != "" ){
                            divider.classList.add(dividerColor);
                        }
                        cardBodyDivContent.appendChild(divider);
                    }

                }


                if(item.accDescription && item.accDescription != ""){
                    let descElem = document.createElement("p");
                    descElem.classList.add('mb-0');
                    descElem.innerHTML = item.accDescription;
                    cardBodyDivContent.appendChild(descElem);
                }

                cardElem.appendChild(cardBodyDivContent);
                colElem.appendChild(cardElem);
                elemDiv.appendChild(colElem);

            });
        
        } else {

            const swiperWrapper = document.createElement("div");
            swiperWrapper.classList.add('swiper-wrapper');
            //swiperWrapper.classList.add('h-auto');

            const swiperOptions = {
                spaceBetween: elemDetails.value.data.spaceBetween
            };

            elemDetails.value.data.accItems.forEach((item,index) => {
            
                let colElem = document.createElement("div");
                let cardElem = document.createElement("div");
                colElem.classList.add('swiper-slide','my-0');
                //cardElem.classList.add('w-100');

                if( elemDetails.value.data.cardRounded && elemDetails.value.data.cardRounded != "" ){
                    cardElem.classList.add(elemDetails.value.data.cardRounded);
                }

                if( elemDetails.value.data.cardBgColor && elemDetails.value.data.cardBgColor != "" ){
                    cardElem.classList.add(elemDetails.value.data.cardBgColor);
                }

                if( elemDetails.value.data.textAlign && elemDetails.value.data.textAlign != "" ){
                    cardElem.classList.add(elemDetails.value.data.textAlign);
                }

                if(item.cardExtraClassess){
                    let classes = item.cardExtraClassess.split(' ');
                    classes.forEach(cl => {
                        if( cl &&  cl != ""){
                            cardElem.classList.add(cl);
                        }
                    });
                }

                Object.entries(elemDetails.value.data.cardPadding).forEach(([key, val]) => {
                    if(val && val != ""){
                        cardElem.classList.add(val);
                    }
                });

                if( elemDetails.value.data.cardNumbers ){
                    let numberDiv = document.createElement("div");
                    if( elemDetails.value.data.titleColor && elemDetails.value.data.titleColor != "" ){
                        numberDiv.classList.add(elemDetails.value.data.titleColor);
                    }
                    numberDiv.classList.add("card-number");
                    numberDiv.innerHTML = index + 1;
                    cardElem.appendChild(numberDiv);
                }

                if( elemDetails.value.data.imagePosition == 'left' ){

                    cardElem.classList.add("hstack","gap-3","h-100");

                    if( elemDetails.value.data.imageAlign && elemDetails.value.data.imageAlign != "" ){
                        cardElem.classList.add(elemDetails.value.data.imageAlign);
                    } else {
                        cardElem.classList.add("align-items-start");
                    }

                } else {

                    cardElem.classList.add("vstack","gap-3","h-100");

                    if( elemDetails.value.data.imagePosition == 'bottom' ){
                        cardElem.classList.add("flex-column-reverse");
                    }

                }

                let imgDivElem = document.createElement("div");
                let imgElem = document.createElement("img");
                imgDivElem.classList.add('overflow-hidden');
                imgElem.classList.add('img-fluid');
                imgElem.loading = "lazy";

                if (elemDetails.value.data.imageBgColor && elemDetails.value.data.imageBgColor != "") {
            
                    imgDivElem.classList.add("p-2",elemDetails.value.data.imageBgColor);

                }

                if (elemDetails.value.data.imageMaxWidth && elemDetails.value.data.imageMaxWidth != "") {
            
                    let minMaxClassesArr = elemDetails.value.data.imageMaxWidth.split(" ");
                    minMaxClassesArr.forEach(cls => {
                        imgDivElem.classList.add(cls);
                    });

                }

                if (elemDetails.value.data.textAlign && elemDetails.value.data.textAlign == "text-center") {
            
                    imgDivElem.classList.add("mx-auto");

                }

                if (elemDetails.value.data.imageRounded && elemDetails.value.data.imageRounded != "") {
                    
                    imgDivElem.classList.add("p-2",elemDetails.value.data.imageRounded);
                    imgElem.classList.add(elemDetails.value.data.imageRounded);

                }

                if(item.imgExtraClasses){
                    let classes = item.imgExtraClasses.split(' ');
                    classes.forEach(cl => {
                        if( cl &&  cl != ""){
                            imgDivElem.classList.add(cl);
                        }
                    });
                }

                let media = item.accMedia;

                if(media){

                    if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" ){

                        imgElem.src = media.original_url;
                        imgElem.width = media.custom_properties.width;
                        imgElem.height = media.custom_properties.height;

                    } else {

                        imgElem.src = media.conversion_urls[elemDetails.value.data.conversion];

                        switch (elemDetails.value.data.conversion) {

                            case "op_url":
                            imgElem.width = 1300;
                            break;
                        
                            case "th_url":
                            imgElem.width = 992;
                            break;

                            default:
                            let convArr = elemDetails.value.data.conversion.replace('_url','').split('x')
                            imgElem.width = convArr[0];
                            imgElem.height = convArr[1];
                            break;
                        }

                        if( elemDetails.value.data.conversion == 'op' ){
                            imgElem.width = 1300;
                        }
                    }

                    imgElem.alt = media.name;

                    if (elemDetails.value.data.lightbox) {
            
                        imgDivElem.setAttribute("data-fancybox",elemDetails.value.id);
                        imgDivElem.setAttribute("data-src",media.original_url);
                        imgDivElem.classList.add("cursor-pointer");

                    }

                    imgDivElem.appendChild(imgElem);
                    cardElem.appendChild(imgDivElem);
                    colElem.appendChild(cardElem);

                }

                let cardBodyDivContent = document.createElement("div");
                cardBodyDivContent.classList.add("d-flex","flex-column","gap-2");

                if(item.contentAreaExtraClasses){
                    let classes = item.contentAreaExtraClasses.split(' ');
                    classes.forEach(cl => {
                        if( cl &&  cl != ""){
                            cardBodyDivContent.classList.add(cl);
                        }
                    });
                }

                if(item.accTitle && item.accTitle != ""){
                    let titleElem = document.createElement(elemDetails.value.data.titleTag);
                    titleElem.classList.add(elemDetails.value.data.titleSize);
                    titleElem.classList.add("mb-0","lh-sm");

                    let dividerColor = "";

                    if( elemDetails.value.data.titleColor && elemDetails.value.data.titleColor != "" ){
                        titleElem.classList.add(elemDetails.value.data.titleColor);
                        dividerColor = "border-"+elemDetails.value.data.titleColor.split("-")[1];
                    }
                    if( elemDetails.value.data.titleFontWeight && elemDetails.value.data.titleFontWeight != "" ){
                        titleElem.classList.add(elemDetails.value.data.titleFontWeight);
                    }
                    titleElem.innerHTML = item.accTitle;
                    cardBodyDivContent.appendChild(titleElem);

                    if( elemDetails.value.data.titleDivider ){
                        let divider = document.createElement("hr");
                        divider.classList.add("my-1","opacity-100","border-top");
                        if( dividerColor != "" ){
                            divider.classList.add(dividerColor);
                        }
                        cardBodyDivContent.appendChild(divider);
                    }

                }

                if(item.accDescription && item.accDescription != ""){
                    let descElem = document.createElement("p");
                    descElem.classList.add('mb-0');
                    descElem.innerHTML = item.accDescription;
                    cardBodyDivContent.appendChild(descElem);
                }

                cardElem.appendChild(cardBodyDivContent);
                colElem.appendChild(cardElem);
                swiperWrapper.appendChild(colElem);

            });

            elemDiv.appendChild(swiperWrapper);

            if( elemDetails.value.data.pagination ){

                const paginationDiv = document.createElement("div");
                paginationDiv.classList.add('swiper-pagination');
                elemDiv.appendChild(paginationDiv);

                swiperOptions.pagination = {
                    el: ".swiper-pagination",
                    clickable:true,
                };

            }

            if( elemDetails.value.data.navigation ){

                const prevDiv = document.createElement("div");
                const nextDiv = document.createElement("div");
                nextDiv.classList.add('swiper-button-next');
                prevDiv.classList.add('swiper-button-prev');
                elemDiv.appendChild(nextDiv);
                elemDiv.appendChild(prevDiv);

                swiperOptions.navigation = {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                };

            }

            swiperOptions.loop = elemDetails.value.data.loop;
            if( elemDetails.value.data.centeredSlides ){
                swiperOptions.centeredSlides = true;
                if( elemDetails.value.data.accItems.length > 4 ){
                    swiperOptions.initialSlide = 2;
                }
            }
            swiperOptions.slidesPerView = elemDetails.value.data.columnCounts.xl + elemDetails.value.data.nextPrevVisibleArea.xl;

            swiperOptions.breakpoints = {
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

            elemDiv.dataset.swiperOptions = JSON.stringify(swiperOptions);
        
        }


        htmlDiv.appendChild(elemDiv);


        let prev_html = '<b>Card Gallery</b>';

        elemDetails.value.data.prevHtml = prev_html;
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

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