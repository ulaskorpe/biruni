<template>
                
    <div v-if="props.templateType == 'section'">
        
        <h2>Kayıtlı Section Seçiniz</h2>
        <Divider />

        <div class="row g-3">
            <div class="col-md-6 col-lg-4 col-xxl-3" v-for="(section,s) in savedSections" :key="s">
                <button class="btn btn-outline-dark w-100" @click="addSavedSection(section)">
                    {{ section.name }}
                </button>
            </div>
        </div>

    </div>

    <div v-if="props.templateType == 'container'">
        
        <h2>Kayıtlı Container Seçiniz</h2>
        <Divider />

        <div class="row g-3">
            <div class="col-md-6 col-lg-4 col-xxl-3" v-for="(container,s) in savedContainers" :key="s">
                <button class="btn btn-outline-dark w-100" @click="addSavedContainer(container)">
                    {{ container.name }}
                </button>
            </div>
        </div>

    </div>

    <div v-if="props.templateType == 'row'">
        
        <h2>Kayıtlı Row Seçiniz</h2>
        <Divider />

        <div class="row g-3">
            <div class="col-md-6 col-lg-4 col-xxl-3" v-for="(row,s) in savedRows" :key="s">
                <button class="btn btn-outline-dark w-100" @click="addSavedRow(row)">
                    {{ row.name }}
                </button>
            </div>
        </div>

    </div>

    <div v-if="props.templateType == 'column'">
        
        <h2>Kayıtlı Column Seçiniz</h2>
        <Divider />

        <div class="row g-3">
            <div class="col-md-6 col-lg-4 col-xxl-3" v-for="(column,s) in savedColumns" :key="s">
                <button class="btn btn-outline-dark w-100" @click="addSavedColumn(column)">
                    {{ column.name }}
                </button>
            </div>
        </div>

    </div>

    <div v-if="props.templateType == 'element'">
        
        <h2>Kayıtlı Element Seçiniz</h2>
        <Divider />

        <div class="row g-3">
            <div class="col-md-6 col-lg-4 col-xxl-3" v-for="(element,s) in savedElements" :key="s">
                <button class="btn btn-outline-dark w-100" @click="addSavedElement(element)">
                    {{ element.name }}
                </button>
            </div>
        </div>

    </div>

</template>

<script setup>

import {ref} from "vue";

import Divider from "primevue/divider";

const props = defineProps({
    form:Object,
    templateType:String,
    sectionIndex:{
        type:Number,
        default:null
    },
    containerIndex:{
        type:Number,
        default:null
    },
    rowIndex:{
        type:Number,
        default:null
    },
    columnIndex:{
        type:Number,
        default:null
    },
    onSelect:{
        type:Function,
        default:() => {}
    }
});

const form = ref(props.form);
const savedSections = ref(null);
const savedContainers = ref(null);
const savedRows = ref(null);
const savedColumns = ref(null);
const savedElements = ref(null);

if (props.templateType == 'section') {
    
    fetch(route('saved-sections.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
    savedSections.value = json;
   });

}

if (props.templateType == 'container') {
    
    fetch(route('saved-containers.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
        savedContainers.value = json;
   });

}

if (props.templateType == 'row') {
    
    fetch(route('saved-rows.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
        savedRows.value = json;
   });

}

if (props.templateType == 'column') {
    
    fetch(route('saved-columns.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
        savedColumns.value = json;
   });

}

if (props.templateType == 'element') {
    
    fetch(route('saved-elements.index'),{
       headers:{
           'Accept':'application/json'
       }
   }).then(function(response) {
       return response.json();
   }).then((json) => {
        savedElements.value = json;
   });

}

const addSavedSection = (section) => {

    section.json_data.settings.id = 'section_' + Date.now();
    section.json_data.containers.forEach((container, c) => {
        container.settings.id = "container_" + Date.now() + "_" +c;
        container.rows.forEach((row, r) => {
            row.settings.id = "row_" + Date.now() + "_" + c + "_" + r;
            row.columns.forEach((column, co) => {
                column.settings.id = "column_" + Date.now() + "_" + c + "_" + r + "_" + co;
                column.elements.forEach((elem, e) => {
                    elem.id = "elem_" + Date.now() + "_" + c + "_" + r + "_" + co + "_" + e;
                    if( elem.data.htmlId ){
                        elem.data.htmlId = "html_" + Date.now() + "_" + c + "_" + r + "_" + co + "_" + e;
                    }
                });
            });
        });
    });
    form.value.content.push(section.json_data);
    props.onSelect();

}

const addSavedContainer = (container) => {

    container.json_data.settings.id = 'container_' + Date.now();
    container.json_data.rows.forEach((row, r) => {
        row.settings.id = "row_" + Date.now() + "_" + r;
        row.columns.forEach((column, co) => {
            column.settings.id = "column_" + Date.now() + "_" + r + "_" + co;
            column.elements.forEach((elem, e) => {
                elem.id = "elem_" + Date.now() + "_" + r + "_" + co + "_" + e;
                if( elem.data.htmlId ){
                    elem.data.htmlId = "html_" + Date.now() + "_" + r + "_" + co + "_" + e;
                }
            });
        });
    });
    form.value.content[props.sectionIndex].containers.push(container.json_data);
    props.onSelect();

}

const addSavedRow = (row) => {

    row.json_data.settings.id = 'row_' + Date.now();
    row.json_data.columns.forEach((column,co) => {
        column.settings.id = "column_" + Date.now() + "_" + co;
        column.elements.forEach((elem, e) => {
            elem.id = "elem_" + Date.now() + "_" + co + "_" + e;
            if( elem.data.htmlId ){
                elem.data.htmlId = "html_" + Date.now() + "_" + co + "_" + e;
            }
        });
    });
    form.value.content[props.sectionIndex].containers[props.containerIndex].rows.push(row.json_data);
    props.onSelect();

}

const addSavedColumn = (column) => {

    column.json_data.settings.id = 'column_' + Date.now();
    column.json_data.elements.forEach((elem, e) => {
        elem.id = "elem_" + Date.now() + "_" + e;
        if( elem.data.htmlId ){
            elem.data.htmlId = "html_" + Date.now() + "_" + e;
        }
    });
    form.value.content[props.sectionIndex].containers[props.containerIndex].rows[props.rowIndex].columns.push(column.json_data);
    props.onSelect();

}

const addSavedElement = (element) => {

    element.json_data.id = 'element_' + Date.now();
    form.value.content[props.sectionIndex].containers[props.containerIndex].rows[props.rowIndex].columns[props.columnIndex].elements.push(element.json_data);
    props.onSelect();

}

</script>