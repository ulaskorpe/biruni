<template>

    <div class="card-title me-auto" v-if="props.hasSearch">
        <input type="text" class="form-control form-control-sm" placeholder="Ara..." v-model="params.search">
    </div>
    <div class="card-toolbar ms-auto">
        <a v-if="hasExport" :href="exportUri" target="_blank" class="btn fw-bold btn-sm btn-light-warning d-flex align-items-center me-3"><i class="bi bi-box-arrow-right fs-4"></i><span class="ms-1 lh-1">Excel</span></a>
        <button v-if="props.filters" type="button" class="btn btn-sm btn-icon" :class="{'btn-primary':!pageHasFilters,'btn-light-success':pageHasFilters}" @click="sidebarVisible = true" v-tooltip.top="'İçerikleri filtrele'"><i class="bi bi-funnel-fill fs-3"></i></button>
        <button v-if="props.filters && pageHasFilters" type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" @click="resetFilters" v-tooltip.top="'Tüm filtreleri kaldır'"><i class="bi bi-x fs-3"></i></button>

    </div>

    <Sidebar v-model:visible="sidebarVisible" position="right" class="w-300px w-lg-500px" v-if="props.filters">

        <div class="row g-4">
            <div v-for="(filter,key) in params.filter" :key="key" :class="{'col-md-12':filter.full_width,'col-md-6':!filter.full_width}">
            
                <label class="form-label">{{ filter.label }}</label>

                <Dropdown v-if="filter.type == 'selectSingle'" v-model="filter.value" showClear variant="filled" :options="filter.options" optionLabel="label" optionValue="value" dataKey="value" placeholder="Lütfen seçiniz" class="w-100" @change="onChangeFilter"/>

                <MultiSelect v-if="filter.type == 'select'" :virtualScrollerOptions="{ itemSize: 44 }" variant="filled" v-model="filter.value" display="chip" filter :options="filter.options" optionLabel="label" optionValue="value" dataKey="value" placeholder="Lütfen seçiniz" :maxSelectedLabels="5" class="w-100" @change="onChangeFilter"/>
                
                <MultiSelect v-if="filter.type == 'selectGroup'" v-model="filter.value" display="chip" filter variant="filled" :options="filter.options" optionLabel="name" optionValue="id" optionGroupLabel="label" optionGroupChildren="value" placeholder="Lütfen seçiniz" :maxSelectedLabels="5" class="w-100" @change="onChangeFilter"/>

                <div class="p-inputgroup" v-if="filter.type == 'search'">
                    <InputText v-model="filter.value" variant="filled" :placeholder="filter.label" />
                    <Button icon="bi bi-x" severity="secondary" v-if="filter.value" @click="resetFilterSearchInput(filter,key)"/>
                    <Button icon="bi bi-search" @click="onChangeFilter" v-if="filter.value"/>
                </div>

                <Calendar v-if="filter.type == 'date'" showButtonBar variant="filled" v-model="filter.value" dateFormat="dd-mm-yy" class="w-100" @date-select="onChangeFilter" @clear-click="onChangeFilter"/>

            </div>
        </div>

    </Sidebar>

    <BlockUI :blocked="blocked" fullScreen />

</template>

<script setup>

import {ref,watch} from "vue";
import debounce from "lodash/debounce";
import qs from "qs";
import { router, usePage } from '@inertiajs/vue3';
import MultiSelect from 'primevue/multiselect';
import InputText from 'primevue/inputtext';
import Sidebar from 'primevue/sidebar';
import BlockUI from 'primevue/blockui';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';

const props = defineProps({
    uri:String,
    filters:{
        type:Object,
        default:null
    },
    hasSearch:{
        type:Boolean,
        default:true
    },
    hasExport:{
        type:Boolean,
        default:false
    },
    extraParams:{
        type:String,
        default:null
    }
});

const sidebarVisible = ref(false);
const blocked = ref(false);

const uriParams = ref(usePage().props.queryParams);
const pageHasFilters = ref(uriParams.value.hasOwnProperty('filter'));

let params = ref({
    filter:props.filters,
    search:uriParams.value.search,
    sort:uriParams.value.sort || null
});

const requestUriParams = {
    filter:uriParams.value.filter,
    search:"",
    language:usePage().props.current_language,
    sort:uriParams.value.sort || null
};

const prepareExportUri = () => {

    requestUriParams.filter = {};
    requestUriParams.search = params.value.search;

    Object.keys(params.value.filter).forEach(key => {
        if( params.value.filter[key].value != "" ) {
            requestUriParams.filter[key] = params.value.filter[key].value;
        }
    });

    Object.keys(requestUriParams).forEach((key) => {
        if (requestUriParams[key] == "" || requestUriParams[key] == null || typeof requestUriParams[key] == "undefined") {
            delete requestUriParams[key];
        }
    });

    let exportQueryStart = props.extraParams ? '?export=true&'+props.extraParams+'&' : '?export=true&';

    return props.uri+exportQueryStart+qs.stringify(requestUriParams);

};

const exportUri = ref(prepareExportUri());

const refreshExportUri = () => {

    let currentExportUri = prepareExportUri();
    exportUri.value = currentExportUri;

};

const getFilteredData = () => {

    blocked.value = true;

    Object.keys(requestUriParams).forEach((key) => {
        if (requestUriParams[key] == "" || requestUriParams[key] == null || typeof requestUriParams[key] == "undefined") {
            delete requestUriParams[key];
        }
    });

    let queryStart = props.extraParams ? '?'+props.extraParams+'&' : '?';

    router.visit(props.uri+queryStart+qs.stringify(requestUriParams),{
        method: 'get',
        preserveState: (page) => page.props.queryParams.hasOwnProperty('filter') ? true : false,
        onSuccess: page => {
            pageHasFilters.value = page.props.queryParams.hasOwnProperty('filter');
            params.value.filter = props.filters;
            refreshExportUri();
        },
        onFinish: visit => {
            blocked.value = false;
            document.querySelector('body').classList.remove("p-overflow-hidden");
            setTimeout(() => {
                //preserveState sebebiyle false yapmak yetmiyor. html i de remove etmeliyiz.
                //Ancak filter aktifken preserveState false oldugundan, sadece varsa kaldiralim.
                var blockUIDOMElement = document.querySelector('.p-blockui');
                if( blockUIDOMElement ){
                    blockUIDOMElement.remove();
                }
            }, 500);
        },
    });

}

const onChangeFilter = () => {

    requestUriParams.filter = {};
    requestUriParams.search = params.value.search;

    Object.keys(params.value.filter).forEach(key => {
        if( params.value.filter[key].value != "" ) {
            requestUriParams.filter[key] = params.value.filter[key].value;
        }
    });

    getFilteredData();

}

const resetFilters = () => {
    requestUriParams.filter = {};
    requestUriParams.search = params.value.search;
    getFilteredData();
}

const resetFilterSearchInput = (filter,key) => {

    filter.value = "";
    if( pageHasFilters.value && requestUriParams.filter[key]){
        requestUriParams.filter[key] = "";
        onChangeFilter();
    }

}

watch(() => ([params.value.search]), debounce(function (){
    
    requestUriParams.search = params.value.search;
    getFilteredData();

},500));

</script>