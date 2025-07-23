<template>
    
    <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0 text-uppercase">
            <span class="d-flex align-items-center">{{ props.title }} listesi <span class="badge badge-dark p-2 ms-2 text-uppercase">{{ $page.props.current_language }}</span></span>
        </h1>
    </div>

    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <Dropdown v-model="selectedLanguage" :options="languages" optionLabel="code" class="fw-bold text-uppercase" @change="reloadPage($event)">
            <template #value="slotProps">
                <div class="d-flex align-items-center">
                    <img :src="slotProps.value.flag" class="me-2" style="width: 12px" />
                    <div class="text-uppercase">{{ slotProps.value.code }}</div>
                </div>
            </template>
            <template #option="slotProps">
                <div class="d-flex align-items-center">
                    <img :src="slotProps.option.flag" class="me-2" style="width: 12px" />
                    <div class="text-uppercase">{{ slotProps.option.code }}</div>
                </div>
            </template>
        </Dropdown>
    </div>
    
</template>
<script setup>

import { router,usePage } from '@inertiajs/vue3';
import { ref,onBeforeMount } from 'vue';
import Dropdown from 'primevue/dropdown';

const props = defineProps({
    routeName: String,
    title: String
});

const languages = ref([]);
const selectedLanguage = ref({
    code:usePage().props.current_language,
    flag:'/dmn/media/flags/'+usePage().props.current_language+'.svg'
});

const reloadPage = (event) => {
    
    router.visit(route(props.routeName,event.value.params),{
        method:'GET'
    });

}

onBeforeMount(() => {

    usePage().props.languages.active.forEach(lang => {
        
        let currentParams = JSON.parse(JSON.stringify(usePage().props.queryParams));
        currentParams['language'] = lang;

        languages.value.push({
            code:lang,
            params:currentParams,
            flag:'/dmn/media/flags/'+lang+'.svg'
        });

    });

});

</script>