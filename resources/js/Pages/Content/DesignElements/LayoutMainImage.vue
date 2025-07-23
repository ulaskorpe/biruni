<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.conversion" :options="conversions" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <div v-if="!elemDetails.data.linkAttribute">
            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">LIGHTBOX</label>
                <div class="col-md-9">
                    <InputSwitch v-model="elemDetails.data.lightbox" />
                </div>
            </div>
        </div>

        <div v-if="!elemDetails.data.lightbox">
            
            <Divider />
            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">Ek SEÇENEK LINK</label>
                <div class="col-md-9">
                    <Dropdown v-model="elemDetails.data.linkAttribute" showClear :options="attributeList" optionLabel="name" class="w-100"/>
                </div>
            </div>

            <div v-if="elemDetails.data.linkAttribute">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-3 fw-bold text-uppercase">YENİ PENCERE</label>
                    <div class="col-md-9">
                        <InputSwitch v-model="elemDetails.data.linkNewWindow" />
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

import {ref,onBeforeMount} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import BaseDesignOptions from "./BaseDesignOptions";


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
    type:'layout_mainimage',
    layout:true,
    data:{
        name:"CONTENT MAIN IMAGE",
        prevHtml:"",
        elemHtml:"",
        lightbox:false,
        linkAttribute:null,
        linkNewWindow:false,
        conversion:"",
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

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("img");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
        const linkElem = document.createElement("a");

        elemDiv.classList.add("img-fluid");

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

        if( !elemDetails.value.data.conversion || elemDetails.value.data.conversion == "" ){
            elemDiv.src = "--ORG_URL--";
            elemDiv.width = "9999";
            elemDiv.height = "8888";
        } else {
            elemDiv.src = "--CONVERSION_URL--";
            switch (elemDetails.value.data.conversion) {
                case "op_url":
                elemDiv.width = 1300;
                break;
            
                case "th_url":
                elemDiv.width = 992;
                break;

                default:
                let convArr = elemDetails.value.data.conversion.replace('_url','').split('x')
                elemDiv.width = convArr[0];
                elemDiv.height = convArr[1];
                break;
            }

            if( elemDetails.value.data.conversion == 'op' ){
                elemDiv.width = 1300;
            }
        }

        elemDiv.alt = "--ALT--";
        elemDiv.loading = "lazy";


        if (elemDetails.value.data.lightbox) {

            linkElem.href = "--ORG_URL--";
            linkElem.dataset.fancybox = "nofollow";
            linkElem.appendChild(elemDiv);
            htmlDiv.appendChild(linkElem);

        } else if (elemDetails.value.data.linkAttribute) {

            linkElem.href = "--LINK_ATTRIBUTE--";
            
            if(elemDetails.value.data.linkNewWindow){
                linkElem.rel = "nofollow";
                linkElem.target = "_blank";
            }

            linkElem.appendChild(elemDiv);
            htmlDiv.appendChild(linkElem);

        } else {

            htmlDiv.appendChild(elemDiv);

        }


        let prev_html = '<div class="hstack gap-3">';
            
            prev_html += '<b>İÇERİK ANA GÖRSEL</b>';

            prev_html += '<div class="vstack gap-1">';
                prev_html += '<small><b>LIGHTBOX</b>: '+elemDetails.value.data.lightbox+'</small>';
            prev_html += '</div>';

        prev_html += '</div>';

        elemDetails.value.data.prevHtml = prev_html;
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
    }
}

const attributeList = ref(null);

const getContentAttributes = () => {

    fetch(route('content-attributes.index'),{
        headers: {
            'Accept': 'application/json',
        }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        attributeList.value = json;
    });

}

onBeforeMount(() => {
    getContentAttributes();
});

</script>