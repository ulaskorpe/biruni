<template>
    <Head head-key="title" :title="`${props.content_type.name} kategorileri`" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <PageTitleWithLanguage :routeName="'content-categories.index'" :title="`${props.content_type.name} Kategorileri`"/>

        </div>
    </div>

    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-header px-4">
                    <div class="card-toolbar w-100 justify-content-between gap-2">
                        <Link :href="route('content-categories.create',{contentType:props.content_type.id, language:$page.props.current_language})" class="btn fw-bold btn-sm btn-success d-flex align-items-center">
                            <i class="bi bi-plus-circle fs-4"></i>
                            <span class="ms-1 lh-1">YENİ</span>
                        </Link>
                        <Link :href="route('content-categories.trash',{contentType:props.content_type.id,language:$page.props.current_language})" class="btn fw-bold btn-sm btn-light-danger btn-icon ms-auto" v-tooltip.top="'Çöp Kutusu'">
                            <i class="bi bi-trash fs-4"></i>
                        </Link>
                        <Link :href="route('content-categories.reorder',{contentType:props.content_type.id,language:$page.props.current_language})" class="btn fw-bold btn-sm btn-light d-flex align-items-center">
                            <i class="bi bi-sort-down fs-4"></i>
                            <span class="ms-1 lh-1">SIRALA</span>
                        </Link>
                    </div>
                </div>

                <div class="card-header px-4" v-if="selectedItems.length === 0">
                    <div class="card-title me-auto">
                        <input type="text" class="form-control form-control-sm" placeholder="Ara..." v-model="dtFilters['global'].value">
                    </div>
                    <Filter :filters="props.filters" :uri="route('content-categories.index')" :has-search="false"/>
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-check2-circle me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <DeleteBulkPrompt :uri="route('content-categories.bulk.delete',{language:$page.props.current_language, contentType:props.content_type.id})" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:filters="dtFilters" v-model:selection="selectedItems" :value="props.categories" dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column header="Dil" headerStyle="width: 4rem">
                            <template #body="{ data }">
                                <div class="d-flex align-items-center">
                                    <img :src="`/dmn/media/flags/${data.language}.svg`" class="me-2" style="width: 14px" />
                                    <span class="text-uppercase">{{ data.language }}</span>
                                </div>
                            </template>
                        </Column>
                        <Column header="Bağlı Diller">
                            <template #body="{ data }">
                                <div class="hstack gap-2">
                                    <div v-for="(lang,key) in $page.props.languages.active.filter((l) => l != data.language)" :key="key">
                                        <Link v-if="!hasConnectedLanguage(data,lang)" :href="route('content-categories.create',{contentType:props.content_type.id, language:lang, uuid:data.uuid, from_id:data.id})" class="btn fw-bold btn-sm btn-icon btn-light-danger text-uppercase" v-tooltip.top="'Oluştur'">{{ lang }}</Link>
                                        <Link v-if="hasConnectedLanguage(data,lang)" :href="route('content-categories.edit',[hasConnectedLanguage(data,lang).id,{language:lang}])" class="btn fw-bold btn-sm btn-icon btn-light-info text-uppercase" v-tooltip.top="'Güncelle'">{{ lang }}</Link>
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column header="İsim">
                            <template #body="{ data }">
                                <span v-html="data.depth_name" :class="{'fw-bold fs-5':data.depth === 0}"></span>
                            </template>
                        </Column>
                        <Column field="slug" header="Slug"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <a :href="`${data.uri.final_uri}`" target="_blank" class="ms-2 btn btn-sm text-success btn-link">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <Link :href="route('content-categories.edit',[data.id,{language:data.language}])">
                                        <Button icon="bi bi-pencil" text rounded severity="info" class="ms-2"/>
                                    </Link>
                                    <DeletePrompt :delete-done="resetSelectedItems" :uri="route('content-categories.delete',[data.id,{language:$page.props.current_language, contentType:props.content_type.id}])" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

    </div>

</template>

<script setup>

import {ref} from "vue";
import PageTitleWithLanguage from "../../Components/PageTitleWithLanguage";

import DeletePrompt from "../../Components/DeletePrompt";
import DeleteBulkPrompt from "../../Components/DeleteBulkPrompt";
import DataTable from "primevue/datatable";
import { FilterMatchMode } from 'primevue/api';
import Column from 'primevue/column';
import Filter from "../../Components/Filter";
import Button from "primevue/button";

const props = defineProps({
    categories:Object,
    content_type:Object,
    filters:Object,
    sortables:{
        type:Array,
        default:[]
    }
});

const selectedItems = ref([]);
const metaKey = ref(true);
const selectedCategory = ref(null);

const resetSelectedItems = () => {
    selectedItems.value = [];
}

const resetSelectedCategory = () => {
    selectedCategory.value = null;
}

const dtFilters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const hasConnectedLanguage = (content,lang) => {

    let data = null;
    const dfilter = content.connected_categories.filter((x) => x.language == lang);

    if( dfilter.length ){
        data = dfilter[0];
    }
    return data;

}

</script>