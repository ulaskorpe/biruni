<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">TAG</label>
            <div class="col-md-9">
                <div class="d-flex gap-4">
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h2" name="tag" value="h2" />
                        <label for="title-tag-h2" class="ms-2">H2</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h3" name="tag" value="h3" />
                        <label for="title-tag-h3" class="ms-2">H3</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h4" name="tag" value="h4" />
                        <label for="title-tag-h4" class="ms-2">H4</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h5" name="tag" value="h5" />
                        <label for="title-tag-h5" class="ms-2">H5</label>
                    </div>
                    <div class="d-flex flex align-items-center">
                        <RadioButton v-model="elemDetails.data.tag" inputId="title-tag-h6" name="tag" value="h6" />
                        <label for="title-tag-h6" class="ms-2">H6</label>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Fixed Text</label>
            <div class="col-md-9">
                <InputText class="w-100" v-model="elemDetails.data.text"/>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Typewriter Texts</label>
            <div class="col-md-9">
                <Textarea v-model="elemDetails.data.typewriters" autoResize rows="2" cols="30" class="w-100"/>
                <span class="helper">";" ile ayırarak textleri giriniz.</span>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ID</label>
            <div class="col-md-9">
                <InputText class="w-100" v-model="elemDetails.data.htmlId"/>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">DISPLAY SIZE</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.size" :options="displaySizes" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Color</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.color" :options="textColors" optionValue="value" optionLabel="label" class="w-100" />
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">Font Weight</label>
            <div class="col-md-9">
                <Dropdown v-model="elemDetails.data.weight" :options="fontWeights" optionValue="value" optionLabel="label" class="w-100" />
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
import Textarea from "primevue/textarea";
import Dropdown from "primevue/dropdown";
import RadioButton from 'primevue/radiobutton';
import BaseDesignOptions from "./BaseDesignOptions";
import {textColors,displaySizes,fontWeights, slugify} from "./design-elements-data.js";

const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'title_typewrite',
    data:{
        name:"TITLE TYPEWRITE",
        tag:"h2",
        text:"",
        typewriters:"",
        size:"",
        color:"",
        weight:"",
        htmlId:'title-'+Math.floor(Math.random() * 100000),
        prevHtml:"",
        elemHtml:"",
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

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement(elemDetails.value.data.tag);
        
        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);

        const typewriterMainDiv = document.createElement("span");
        typewriterMainDiv.classList.add("typewrite");
        const typewriterDiv = document.createElement("span");
        typewriterDiv.classList.add("wrap");

        if(elemDetails.value.data.htmlId != ""){
            let slugifId = slugify(elemDetails.value.data.htmlId);
            elemDetails.value.data.htmlId = slugifId;
            elemDiv.id = slugifId;
        }

        if(elemDetails.value.data.size != ""){
            elemDiv.classList.add(elemDetails.value.data.size);
        }

        if(elemDetails.value.data.color && elemDetails.value.data.color != ""){
            elemDiv.classList.add(elemDetails.value.data.color);
        }

        if(elemDetails.value.data.weight && elemDetails.value.data.weight != ""){
            elemDiv.classList.add(elemDetails.value.data.weight);
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

        typewriterMainDiv.dataset.period = 2000;

        if(elemDetails.value.data.typewriters != ""){
            let typeArr = elemDetails.value.data.typewriters.split(';');
            typewriterMainDiv.dataset.type = JSON.stringify(typeArr);
        }

        typewriterMainDiv.appendChild(typewriterDiv);

        if(elemDetails.value.data.text != ""){
            elemDiv.innerHTML = '<span class="me-3">'+elemDetails.value.data.text+'</span>';
        }

        elemDiv.appendChild(typewriterMainDiv);

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        resolve(true);
    });

    const isElementReady = await promise;
    if(isElementReady){
        props.onDone(elemDetails.value);
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