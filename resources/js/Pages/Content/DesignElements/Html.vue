<template>
    
    <div>
        <h4 class="text-dark">{{ elemDetails.data.name }}</h4>
        <Divider class="mb-10"/>

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">CODE</label>
            <div class="col-md-9">
                <AceEditor
                    v-model:codeContent="validHtml" 
                    v-model:editor="editor"
                    :options="{'showPrintMargin': false}"
                    theme="chrome"
                    lang="html"
                    width="100%" 
                    height="300px" 
                />
            </div>
        </div>

        <BaseDesignOptions :base-design-options="elemDetails.data.baseDesignOptions" :anim-options="elemDetails.data.animOptions"/>

        <Divider class="my-10" />

        <Button label="Tamam" @click="prepareElement($event)"/>

    </div>

    <Dialog v-model:visible="errorDialogVisible" @hide="errorDialogErrors = []" modal header="Hata" :style="{ width: '50vw' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        
        <p>Giriş yaptığınız HTML de kod hataları bulunmaktadır. Lütfen kontrol ediniz.</p>
        <div class="alert alert-danger" v-for="(err,index) in errorDialogErrors" :key="index">
            <code>{{ err.extract }}</code>
            <br>
            <span>{{ err.message }}</span>
        </div>
        
    </Dialog>

</template>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import BaseDesignOptions from "./BaseDesignOptions";


import AceEditor from "ace-editor-vue3";
import "brace/mode/html";
import "brace/theme/chrome";

const props = defineProps({
    elem:{
        type:Object,
        default:null,
    },
    onDone:Function
});

const editor = ref(null);
const errorDialogVisible = ref(false);
const errorDialogErrors = ref([]);

let emptyElem = {
    id:"elem_" + Date.now(),
    type:'html',
    data:{
        name:"HTML",
        html:"",
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

const validHtml = ref(elemDetails.value.data.html);

const prepareElement = async (button) => {

    button.target.disabled = true;

    let promise = new Promise(function(resolve, reject) {
      
        try {
            
            const htmlBlock = `<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Document</title></head><body>${validHtml.value}</body></html>`;

            const response = fetch('https://validator.w3.org/nu/?out=json', {
                method: 'POST',
                headers: {
                    'Content-Type': 'text/html; charset=utf-8'
                },
                body: htmlBlock
            }).then(function(response) {
                return response.json();
            }).then((json) => {

                console.log(json);

                if (json.messages) {

                    const exceptInfoMessages = json.messages.filter(msg => {
                        return msg.type != 'info';
                    });

                    if(exceptInfoMessages.length > 0){
                        json.exceptInfoMessages.forEach(err => {
                            errorDialogErrors.value.push(err);
                        });

                        errorDialogVisible.value = true;

                        resolve(false);
                    } else {
                        resolve(true);
                    }

                }


            }).catch(function(error){
                console.log(error);
            });

        } catch (error) {
            console.error(error);
            resolve(false);
        }

    });

    const isElementReady = await promise;
    
    if(isElementReady){

        const htmlDiv = document.createElement("div");
        const elemDiv = document.createElement("div");

        elemDiv.classList.add(elemDetails.value.data.baseDesignOptions.position);
        
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

        elemDiv.innerHTML = validHtml.value;
        elemDetails.value.data.html = validHtml.value;

        htmlDiv.appendChild(elemDiv);

        elemDetails.value.data.prevHtml = htmlDiv.innerHTML;
        elemDetails.value.data.elemHtml = htmlDiv.innerHTML;

        button.target.disabled = false;

        props.onDone(elemDetails.value);

    } else {
        button.target.disabled = false;
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