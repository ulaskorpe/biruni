<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">ITEMS</label>
            <div class="col-md-9">
                <div class="mb-5" v-if="elemDetails.data.tabItems.length > 0">
                    <draggable 
                        v-model="elemDetails.data.tabItems" 
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
                                        <button class="p-panel-header-icon p-link me-2" @click="elemDetails.data.tabItems.splice(a,1)">
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
import Dialog from "primevue/dialog";
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
    type:'tab',
    data:{
        name:"TAB CONTENT",
        prevHtml:"",
        elemHtml:"",
        tabItems:[],
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
    accTitle:"Tab Title",
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
    elemDetails.value.data.tabItems.push(JSON.parse(JSON.stringify(newItem)));
}


const prepareElement = async () => {

    let promise = new Promise(function(resolve, reject) {

        const elemId = 'tab-'+Math.floor(Math.random() * 1000000);
        elemDetails.value.id = elemId;

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
        const buttonsDiv = document.createElement("ul");
        const tabContentsDiv = document.createElement("div");

        buttonsDiv.classList.add("nav","nav-pills","mb-3");
        buttonsDiv.role = "tablist";
        tabContentsDiv.classList.add("tab-content");

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

        elemDetails.value.data.tabItems.forEach((item,index) => {
            
            let buttonItem = document.createElement("li");
            let button = document.createElement("button");
            let contentItem = document.createElement("div");

            buttonItem.classList.add("nav-item");
            buttonItem.role = "presentation";

            button.classList.add("nav-link");
            if( index == 0 ){
                button.classList.add("active");
            }
            button.dataset.bsToggle = "pill";
            button.dataset.bsTarget = '#'+elemId+'-'+index;
            button.role = "tab";
            button.type = "button";
            button.ariaControls = elemId + '-' + index;
            button.ariaSelected = index == 0 ? true : false;
            button.innerText = item.accTitle;

            buttonItem.appendChild(button);
            buttonsDiv.appendChild(buttonItem);

            contentItem.classList.add("tab-pane","fade");
            if( index == 0 ){
                contentItem.classList.add("show","active");
            }
            contentItem.id = elemId + '-' + index;
            contentItem.role = "tabpanel";
            contentItem.tabIndex = index;
            contentItem.innerHTML = item.accContent;
            tabContentsDiv.appendChild(contentItem);
            

        });

        elemDiv.appendChild(buttonsDiv);
        elemDiv.appendChild(tabContentsDiv);
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


</script>