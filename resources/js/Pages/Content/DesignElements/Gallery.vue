<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">GALLERY ID</label>
            <div class="col-md-9">
                <InputText v-model="elemDetails.data.swiperId" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SELECT IMAGES</label>
            <div class="col-md-9">
                <div class="row g-3 row-cols-3 row-cols-lg-6 my-2">
                    <div class="col" v-for="(media,m) in elemDetails.data.medias" :key="m">
                        <div class="overlay overflow-hidden rounded">
                            <div class="overlay-wrapper">
                                <img :src="media.preview_url" class="img-fluid rounded cursor-pointer" />
                            </div>
                            <div class="overlay-layer bg-dark bg-opacity-25">
                                <button type="button" class="btn btn-light-danger btn-sm btn-icon" @click="removeFromGallery(m)"><i class="bi bi-x fs-3"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <PopupMediaLibrary :on-select="setGalleryImages" :multiple="true" :button-text="'Select Images'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
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
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">LIGHTBOX</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.lightbox" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMG ROUNDED</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.imgRounded" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">IMG SHADOW</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.imgShadow" />
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

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">NAVIGATION POSITION</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.navigationPosition" :options="['navigation-default','navigation-bottom-right','navigation-top-right']" class="w-100" />
                </div>
            </div>

        </div>

        <div v-if="elemDetails.data.type == 'carousel' || elemDetails.data.type == 'infinitie-loop'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">SLIDES BETWEEN</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.spaceBetween" :options="[0,15,30,50,75,100]" class="w-100" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'infinitie-loop'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">REVERSE DIRECTION</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.reverseDirection" />
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SLIDES HAS SHADOW</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.slidesShadow" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SLIDES ROUNDED</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.slidesRounded" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SLIDES BORDERED</label>
            <div class="col-md-9">
                <InputSwitch v-model="elemDetails.data.slidesBordered" />
            </div>
        </div>

        <div v-if="elemDetails.data.type == 'carousel'">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">SLIDES PER VIEW AUTO</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.slidesPerViewAuto" />
                </div>
            </div>
        </div>

        <div v-if="elemDetails.data.slidesPerViewAuto">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">SLIDES HEIGHT (MOBILE)</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.slidesMobileHeight" :options="['h-100px','h-150px','h-200px','h-250px','h-300px','h-350px','h-400px','h-450px','h-500px','h-600px','h-700px']" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">SLIDES HEIGHT (DESKTOP)</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.slidesHeight" :options="['h-xl-100px','h-xl-150px','h-xl-200px','h-xl-250px','h-xl-300px','h-xl-350px','h-xl-400px','h-xl-450px','h-xl-500px','h-xl-600px','h-xl-700px']" class="w-100" />
                </div>
            </div>
        </div>

        <RowCounts :row-counts="elemDetails.data.rowCounts" v-if="elemDetails.data.type == 'carousel' && !elemDetails.data.slidesPerViewAuto"/>

        <ColumnCounts :column-counts="elemDetails.data.columnCounts" v-if="elemDetails.data.type != 'infinitie-loop' && !elemDetails.data.slidesPerViewAuto"/>

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
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";
import ColumnCounts from "./ColumnCounts";
import RowCounts from "./RowCounts";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";


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
    type:'gallery',
    data:{
        name:"IMAGE gallery",
        swiperId:"",
        medias:[],
        prevHtml:"",
        elemHtml:"",
        lightbox:false,
        conversion:"",
        type:"grid",
        masonry:false,
        pagination:true,
        navigation:false,
        navigationPosition:"navigation-default",
        reverseDirection:false,
        slidesRounded:false,
        slidesShadow:false,
        slidesBordered:false,
        slidesPerViewAuto:false,
        spaceBetween:15,
        slidesHeight:"h-xl-300px",
        slidesMobileHeight:"h-200px",
        imgRounded:false,
        imgShadow:false,
        rowCounts:{
            sm:1,
            md:1,
            lg:1,
            xl:1
        },
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

let galleryTypes = ['grid','carousel','infinitie-loop'];

const elemDetails = ref(emptyElem);
if( props.elem ){
    Object.entries(emptyElem.data).forEach(([key, val]) => {
        if(!props.elem.data.hasOwnProperty(key)){
            props.elem.data[key] = val;
        }
        elemDetails.value = Object.assign(emptyElem,props.elem);
    });
}

const setGalleryImages = (medias) => {
    elemDetails.value.data.medias = [...elemDetails.value.data.medias, ...medias];
}

const removeFromGallery = (index) => {
    elemDetails.value.data.medias.splice(index,1);
}

const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        if( elemDetails.value.data.medias.length == 0 ){
            resolve(false);
        }

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");
        const swiperDiv = document.createElement("div"); //swiper relative obje icinde olmazsa sorun oluyor.
        swiperDiv.classList.add('position-relative');

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

        if(elemDetails.value.data.type == 'grid'){
            elemDiv.classList.add('row','g-3');
            elemDiv.classList.add('row-cols-'+elemDetails.value.data.columnCounts.sm);
            elemDiv.classList.add('row-cols-md-'+elemDetails.value.data.columnCounts.md);
            elemDiv.classList.add('row-cols-lg-'+elemDetails.value.data.columnCounts.lg);
            elemDiv.classList.add('row-cols-xl-'+elemDetails.value.data.columnCounts.xl);
            if (elemDetails.value.data.masonry) {
                elemDiv.setAttribute('data-masonry','{"percentPosition": true }')
            }
        } else {
            elemDiv.classList.add('ea-swiper','swiper','opacity-100');
            elemDiv.classList.add(elemDetails.value.data.navigationPosition);

            if( elemDetails.value.data.swiperId && elemDetails.value.data.swiperId != "" ){
                elemDiv.id = elemDetails.value.data.swiperId;
            }
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

            elemDetails.value.data.medias.forEach(media => {
            
                let colElemDiv = document.createElement("div");
                colElemDiv.classList.add('col');

                let colElem = document.createElement("div");
                colElem.classList.add('w-100','h-100');

                if( elemDetails.value.data.slidesBordered ){
                    colElem.classList.add('border');
                }

                if( elemDetails.value.data.slidesRounded ){
                    colElem.classList.add('rounded');
                }   

                if( elemDetails.value.data.slidesShadow ){
                    colElem.classList.add('shadow');
                }
                

                let imgElem = document.createElement("img");
                imgElem.classList.add('img-fluid');
                imgElem.loading = "lazy";

                if( elemDetails.value.data.imgRounded ){
                    imgElem.classList.add('rounded');
                }
                if( elemDetails.value.data.imgShadow ){
                    imgElem.classList.add('shadow');
                }

                if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" || elemDetails.value.data.conversion == null ){

                    imgElem.src = media.original_url;
                    imgElem.width = media.custom_properties.width;
                    imgElem.height = media.custom_properties.height;
                    
                } else {

                    imgElem.src = media.conversion_urls[elemDetails.value.data.conversion];

                    switch (elemDetails.value.data.conversion) {

                        case "op_url":
                        imgElem.width = media.custom_properties.op_width;
                        imgElem.height = media.custom_properties.op_height;
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
                        imgElem.width = media.custom_properties.op_width;
                        imgElem.height = media.custom_properties.op_height;
                    }
                }

                imgElem.alt = media.name;

                if (elemDetails.value.data.lightbox) {

                    let linkElem = document.createElement("a");
                    linkElem.href = media.original_url;
                    linkElem.dataset.fancybox = elemDetails.value.id;
                    linkElem.appendChild(imgElem);
                    colElem.appendChild(linkElem);

                } else {
                    colElem.appendChild(imgElem);
                }

                colElemDiv.appendChild(colElem);
                elemDiv.appendChild(colElemDiv);

            });
        
        } else if (elemDetails.value.data.type == 'carousel') {

            const swiperWrapper = document.createElement("div");
            swiperWrapper.classList.add('swiper-wrapper');

            const swiperOptions = {};

            elemDetails.value.data.medias.forEach(media => {
            
                let colElem = document.createElement("div");
                colElem.classList.add('swiper-slide');

                if( elemDetails.value.data.slidesBordered ){
                    colElem.classList.add('border');
                }

                if( elemDetails.value.data.slidesRounded ){
                    colElem.classList.add('overflow-hidden','rounded');
                }   

                if( elemDetails.value.data.slidesShadow ){
                    colElem.classList.add('shadow');
                }

                if( elemDetails.value.data.slidesPerViewAuto ){
                    colElem.classList.add('w-auto');
                }

                if( elemDetails.value.data.slidesPerViewAuto && elemDetails.value.data.slidesHeight ){
                    colElem.classList.add(elemDetails.value.data.slidesMobileHeight);
                    colElem.classList.add(elemDetails.value.data.slidesHeight);
                }

                let imgElem = document.createElement("img");
                imgElem.classList.add('h-100', 'w-auto','mw-100', 'object-fit-cover');
                imgElem.loading = "lazy";

                if( elemDetails.value.data.imgRounded ){
                    imgElem.classList.add('rounded');
                }
                if( elemDetails.value.data.imgShadow ){
                    imgElem.classList.add('shadow');
                }

                if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" || elemDetails.value.data.conversion == null ){

                    imgElem.src = media.original_url;
                    imgElem.width = media.custom_properties.width;
                    imgElem.height = media.custom_properties.height;

                } else {

                    imgElem.src = media.conversion_urls[elemDetails.value.data.conversion];

                    switch (elemDetails.value.data.conversion) {

                        case "op_url":
                        imgElem.width = media.custom_properties.op_width;
                        imgElem.height = media.custom_properties.op_height;
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
                        imgElem.width = media.custom_properties.op_width;
                        imgElem.height = media.custom_properties.op_height;
                    }
                }

                imgElem.alt = media.name;

                if (elemDetails.value.data.lightbox) {

                    let linkElem = document.createElement("a");
                    linkElem.href = media.original_url;
                    linkElem.dataset.fancybox = elemDetails.value.id;
                    linkElem.appendChild(imgElem);
                    colElem.appendChild(linkElem);

                } else {
                    colElem.appendChild(imgElem);
                }

                swiperWrapper.appendChild(colElem);

            });

            elemDiv.appendChild(swiperWrapper);

            if( elemDetails.value.data.pagination ){

                const paginationDiv = document.createElement("div");
                paginationDiv.classList.add('swiper-pagination');
                elemDiv.appendChild(paginationDiv);

                swiperOptions.pagination = {
                    el: ".swiper-pagination",
                    clickable:true
                };

            }

            if( elemDetails.value.data.navigation ){

                const navDiv = document.createElement("div");
                navDiv.classList.add('swiper-navigation-div','container');

                const prevDiv = document.createElement("div");
                const nextDiv = document.createElement("div");

                nextDiv.classList.add('swiper-button-next');
                prevDiv.classList.add('swiper-button-prev');

                if( elemDetails.value.data.navigationPosition == 'navigation-default' ){ 

                    elemDiv.appendChild(prevDiv);
                    elemDiv.appendChild(nextDiv);
                    
                }

                if( elemDetails.value.data.navigationPosition == 'navigation-bottom-right' ){

                    navDiv.appendChild(prevDiv);
                    navDiv.appendChild(nextDiv);

                    elemDiv.appendChild(navDiv);

                }

                if( elemDetails.value.data.navigationPosition == 'navigation-top-right' ){

                    navDiv.appendChild(prevDiv);
                    navDiv.appendChild(nextDiv);

                    elemDiv.prepend(navDiv);

                }


                swiperOptions.navigation = {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                };

            }

            swiperOptions.spaceBetween = elemDetails.value.data.spaceBetween;

            if( elemDetails.value.data.slidesPerViewAuto ){

                swiperOptions.slidesPerView = 'auto';
                swiperOptions.freeMode = false;
                swiperOptions.mousewheel = true;
                swiperOptions.grabCursor = true;

            } else {

                swiperOptions.slidesPerView = 1;

                swiperOptions.breakpoints = {
                    400: {
                        slidesPerView: elemDetails.value.data.columnCounts.sm,
                        grid:{
                            rows: elemDetails.value.data.rowCounts.sm,
                        }
                    },
                    768: {
                        slidesPerView: elemDetails.value.data.columnCounts.md,
                        grid:{
                            rows: elemDetails.value.data.rowCounts.md,
                        }
                    },
                    998: {
                        slidesPerView: elemDetails.value.data.columnCounts.lg,
                        grid:{
                            rows: elemDetails.value.data.rowCounts.lg,
                        }
                    },
                    1200: {
                        slidesPerView:  elemDetails.value.data.columnCounts.xl,
                        grid:{
                            rows: elemDetails.value.data.rowCounts.xl,
                        }
                    }
                };
            }

            elemDiv.dataset.swiperOptions = JSON.stringify(swiperOptions);
        
        } else if (elemDetails.value.data.type == 'infinitie-loop') {

            const swiperWrapper = document.createElement("div");
            swiperWrapper.classList.add('swiper-wrapper');
            swiperWrapper.classList.add('infinitie-free-swiper');

            const swiperOptions = {
                grabCursor: true,
                a11y: false,
                freeMode: true,
                speed: 11000,
                loop: true,
                slidesPerView: "auto",
                spaceBetween:0,
                autoplay: {
                    delay: 0.5,
                    disableOnInteraction: false,
                    reverseDirection:elemDetails.value.data.reverseDirection
                },
            };

            elemDetails.value.data.medias.forEach(media => {

                let colElem = document.createElement("div");
                colElem.classList.add('swiper-slide');

                if( elemDetails.value.data.slidesBordered ){
                    colElem.classList.add('border');
                }

                if( elemDetails.value.data.slidesRounded ){
                    colElem.classList.add('rounded');
                }   

                if( elemDetails.value.data.slidesShadow ){
                    colElem.classList.add('shadow');
                }

                let imgElem = document.createElement("img");
                imgElem.classList.add('img-fluid');
                imgElem.loading = "lazy";

                if( elemDetails.value.data.imgRounded ){
                    imgElem.classList.add('rounded');
                }
                if( elemDetails.value.data.imgShadow ){
                    imgElem.classList.add('shadow');
                }

                if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" || elemDetails.value.data.conversion == null ){

                    imgElem.src = media.original_url;
                    imgElem.width = media.custom_properties.width;
                    imgElem.height = media.custom_properties.height;

                } else {

                    imgElem.src = media.conversion_urls[elemDetails.value.data.conversion];

                    switch (elemDetails.value.data.conversion) {

                        case "op_url":
                        imgElem.width = media.custom_properties.op_width;
                        imgElem.height = media.custom_properties.op_height;
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
                        imgElem.width = media.custom_properties.op_width;
                        imgElem.height = media.custom_properties.op_height;
                    }
                }

                imgElem.alt = media.name;

                if (elemDetails.value.data.lightbox) {

                    let linkElem = document.createElement("a");
                    linkElem.href = media.original_url;
                    linkElem.dataset.fancybox = elemDetails.value.id;
                    linkElem.appendChild(imgElem);
                    colElem.appendChild(linkElem);

                } else {
                    colElem.appendChild(imgElem);
                }

                swiperWrapper.appendChild(colElem);

            });

            elemDiv.appendChild(swiperWrapper);

            elemDiv.dataset.swiperOptions = JSON.stringify(swiperOptions);

        }

        if(elemDetails.value.data.type == 'grid'){
            htmlDiv.appendChild(elemDiv);
        } else {

            swiperDiv.appendChild(elemDiv);
            htmlDiv.appendChild(swiperDiv);
        }


        let prev_html = '<div class="hstack gap-3 flex-wrap">';
            
            elemDetails.value.data.medias.forEach(med => {
                prev_html += '<img src="'+med.preview_url+'" width="50" />'; 
            });

        prev_html += '</div>';

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


/*
watch(elemDetails.value, () => {

    const htmlDiv = document.createElement("div");
    const title = document.createElement(elemDetails.value.data.tag);
    title.innerText = elemDetails.value.data.text;
    title.classList.add("asd")
    htmlDiv.appendChild(title);

    elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
    elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

});
*/

</script>