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
                                    <div class="d-flex flex-column mb-6">
                                        <label class="form-label">TITLE</label>
                                        <InputText v-model="acc.accTitle" class="w-100" />
                                    </div>

                                    <div class="d-flex flex-column mb-10">
                                        <label class="form-label">CONTENT</label>
                                        <TextEditor v-model="acc.accContent" />
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
import TextEditor from "../../../Components/TextEditor";
import draggable from 'vuedraggable';
import BaseDesignOptions from "./BaseDesignOptions";


const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'accordeon',
    data:{
        name:"ACCORDEON",
        prevHtml:"",
        elemHtml:"",
        accItems:[],
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

let newItem = {
    accTitle:"Accordeon Title",
    accContent:""
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


const addAccItem = () => {
    elemDetails.value.data.accItems.push(JSON.parse(JSON.stringify(newItem)));
}


const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        elemDetails.value.id = 'acc-'+Math.floor(Math.random() * 100000);

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");

        elemDiv.classList.add("accordion");
        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        //elemDiv.classList.add("accordion-flush");
        elemDiv.id = 'acc-'+elemDetails.value.id;

        if(elemDetails.value.data.baseDesignOptions.class){
            let classes = elemDetails.value.data.baseDesignOptions.class.split(' ');
            classes.forEach(cl => {
                if( cl && cl != ""){
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

        elemDetails.value.data.accItems.forEach((item,index) => {
            
            let itemDiv = document.createElement("div");
            itemDiv.classList.add("accordion-item");

            let itemId = 'acc-' + elemDetails.value.id + '-item-' + index;

            let itemHtml = '<span class="accordion-header"><button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#'+itemId+'" aria-expanded="false" aria-controls="'+itemId+'">'+item.accTitle+'</button></span>';
            itemHtml += '<div id="'+itemId+'" class="accordion-collapse collapse" data-bs-parent="#'+elemDiv.id+'">';
                itemHtml += '<div class="accordion-body">'+item.accContent+'</div>';
            itemHtml += '</div>';

            itemDiv.innerHTML = itemHtml;

            elemDiv.appendChild(itemDiv);

        });

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
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