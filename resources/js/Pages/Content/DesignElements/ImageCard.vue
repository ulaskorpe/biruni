<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMAGE</label>
            <div class="col-md-9">
                <div class="d-flex flex-row align-items-center">
                    <img :src="elemDetails.data.cardMedia.preview_url" v-if="elemDetails.data.cardMedia" class="img-thumbnail" width="100"/>
                    <PopupMediaLibrary v-if="!elemDetails.data.cardMedia" :on-select="setAccMedia" :form-model="elemDetails.data.cardMedia" :button-text="'Görsel Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" @click="elemDetails.data.cardMedia = null" v-if="elemDetails.data.cardMedia">
                        <i class="bi bi-x fs-3"></i>
                    </button>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TITLE</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.cardTitle" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DESCRIPTION</label>
            <div class="col-md-9">
                <Textarea v-model="elemDetails.data.cardDescription" rows="2" cols="30" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="vstack gap-3">

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">CARD EXTRA CLASSES</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.cardExtraClassess" class="w-100" />
                </div>
            </div>

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">CONTENT AREA EXTRA CLASSES</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.contentAreaExtraClasses" class="w-100" />
                </div>
            </div>

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">IMAGE EXTRA CLASSES</label>
                <div class="col-md-9">
                    <InputText v-model="elemDetails.data.imgExtraClasses" class="w-100" />
                </div>
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
            <label class="col-md-3 fw-bold text-uppercase">LINK</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.link" class="w-100" />
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
import Textarea from 'primevue/textarea';
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";
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
    type:'image_card',
    data:{
        name:"IMAGE CARD",
        prevHtml:"",
        elemHtml:"",
        cardMedia:null,
        cardTitle:"",
        cardDescription:"",
        cardExtraClassess:"",
        contentAreaExtraClasses:"",
        imgExtraClasses:"",
        link:"",
        imagePosition:"top",
        imageMaxWidth:"",
        imageBgColor:"",
        imageRounded:"",
        textAlign:"text-start",
        imageAlign:"align-items-start",
        conversion:"",
        cardBgColor:"",
        cardRounded:"",
        cardNumbers:false,
        titleColor:"",
        titleFontWeight:"",
        titleDivider:false,
        titleTag:"div",
        titleSize:"h3",
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
    elemDetails.value.data.cardMedia = media;
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        elemDiv.classList.add("w-100");

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

        if( elemDetails.value.data.cardRounded && elemDetails.value.data.cardRounded != "" ){
            elemDiv.classList.add(elemDetails.value.data.cardRounded);
        }

        if( elemDetails.value.data.cardBgColor && elemDetails.value.data.cardBgColor != "" ){
            elemDiv.classList.add(elemDetails.value.data.cardBgColor);
        }

        if( elemDetails.value.data.textAlign && elemDetails.value.data.textAlign != "" ){
            elemDiv.classList.add(elemDetails.value.data.textAlign);
        }


        if(elemDetails.value.data.cardExtraClassess){
            let classes = elemDetails.value.data.cardExtraClassess.split(' ');
            classes.forEach(cl => {
                if( cl &&  cl != ""){
                    elemDiv.classList.add(cl);
                }
            });
        }

        if( elemDetails.value.data.cardNumbers ){
            let numberDiv = document.createElement("div");
            if( elemDetails.value.data.titleColor && elemDetails.value.data.titleColor != "" ){
                numberDiv.classList.add(elemDetails.value.data.titleColor);
            }
            numberDiv.classList.add("card-number");
            numberDiv.innerHTML = index + 1;
            elemDiv.appendChild(numberDiv);
        }


        if( elemDetails.value.data.imagePosition == 'left' ){

            elemDiv.classList.add("hstack","gap-3");

            if( elemDetails.value.data.imageAlign && elemDetails.value.data.imageAlign != "" ){
                elemDiv.classList.add(elemDetails.value.data.imageAlign);
            } else {
                elemDiv.classList.add("align-items-start");
            }

        } else {

            elemDiv.classList.add("vstack","gap-3");

            if( elemDetails.value.data.imagePosition == 'bottom' ){
                elemDiv.classList.add("flex-column-reverse");
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

        if(elemDetails.value.data.imgExtraClasses){
            let classes = elemDetails.value.data.imgExtraClasses.split(' ');
            classes.forEach(cl => {
                if( cl &&  cl != ""){
                    imgDivElem.classList.add(cl);
                }
            });
        }

        let media = elemDetails.value.data.cardMedia;

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

            imgDivElem.appendChild(imgElem);
            elemDiv.appendChild(imgDivElem);
        }

        let cardBodyDivContent = document.createElement("div");
        cardBodyDivContent.classList.add("d-flex","flex-column");

        if(elemDetails.value.data.contentAreaExtraClasses){
            let classes = elemDetails.value.data.contentAreaExtraClasses.split(' ');
            classes.forEach(cl => {
                if( cl &&  cl != ""){
                    cardBodyDivContent.classList.add(cl);
                }
            });
        }

        if(elemDetails.value.data.cardTitle && elemDetails.value.data.cardTitle != ""){
            let titleElem = document.createElement(elemDetails.value.data.titleTag);
            let linkElem = document.createElement("a");

            if(elemDetails.value.data.titleSize != ""){
                titleElem.classList.add(elemDetails.value.data.titleSize);
            }
            titleElem.classList.add("mb-0","lh-base");
            let dividerColor = "";

            if( elemDetails.value.data.titleColor && elemDetails.value.data.titleColor != "" ){
                titleElem.classList.add(elemDetails.value.data.titleColor);
                dividerColor = "border-"+elemDetails.value.data.titleColor.split("-")[1];
            }
            if( elemDetails.value.data.titleFontWeight && elemDetails.value.data.titleFontWeight != "" ){
                titleElem.classList.add(elemDetails.value.data.titleFontWeight);
            }

            titleElem.innerHTML = elemDetails.value.data.cardTitle;

            if(elemDetails.value.data.link && elemDetails.value.data.link != ""){
                linkElem.href = elemDetails.value.data.link;
                linkElem.classList.add("stretched-link");
                linkElem.appendChild(titleElem);
                cardBodyDivContent.appendChild(linkElem);
            } else {
                cardBodyDivContent.appendChild(titleElem);
            }
            

            if( elemDetails.value.data.titleDivider ){
                let divider = document.createElement("hr");
                divider.classList.add("my-1","opacity-100","border-top");
                if( dividerColor != "" ){
                    divider.classList.add(dividerColor);
                }
                cardBodyDivContent.appendChild(divider);
            }

        }


        if(elemDetails.value.data.cardDescription && elemDetails.value.data.cardDescription != ""){
            let descElem = document.createElement("p");
            descElem.classList.add('mb-0');
            descElem.innerHTML = elemDetails.value.data.cardDescription;
            cardBodyDivContent.appendChild(descElem);
        }


        elemDiv.appendChild(cardBodyDivContent);

        htmlDiv.appendChild(elemDiv);


        let prev_html = '<b>Image Card: </b>'+elemDetails.value.data.cardTitle;

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