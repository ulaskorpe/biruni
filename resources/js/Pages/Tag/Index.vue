<template>
    <Head head-key="title" title="Etiketler" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <PageTitleWithLanguage :routeName="'tags.index'" :title="'Etiket'"/>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-header px-4">
                    <div class="card-toolbar w-100 justify-content-between gap-2">
                        <NewTag :lang="$page.props.current_language"/>
                    </div>
                </div>

                <div class="card-header px-4" v-if="selectedItems.length === 0">
                    <Filter :filters="props.filters" :uri="route('tags.index')"/>
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-check2-circle me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <DeleteBulkPrompt :uri="route('tags.bulk.delete')" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" :value="props.tags.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
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
                                        <NewTag :lang="lang" :uuid="data.uuid" :from-id="data.id" :button-class="'btn fw-bold btn-sm btn-icon btn-light-danger text-uppercase'" :button-text="lang" v-tooltip.top="'Oluştur'" v-if="!hasConnectedLanguage(data,lang)"/>
                                        <button type="button" v-if="hasConnectedLanguage(data,lang)" @click="selectedTag = hasConnectedLanguage(data,lang)" class="btn fw-bold btn-sm btn-icon btn-light-info text-uppercase" v-tooltip.top="'Güncelle'">{{ lang }}</button>
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column field="name" header="İsim"></Column>
                        <Column field="slug" header="Slug"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="selectedTag = data"/>
                                    <DeletePrompt :delete-done="resetSelectedItems" :uri="route('tags.delete',[data.id,{language:$page.props.current_language}])" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

        <div class="p-5 my-10 bg-light">
            <Pagination :links="props.tags.links" :only="['tags','flash']"/>
        </div>

    </div>

    <EditTag :selected-tag="selectedTag" :on-update-done="resetSelectedTag" v-if="selectedTag" />

</template>

<script setup>

import {ref} from "vue";
import PageTitleWithLanguage from "../../Components/PageTitleWithLanguage";
import NewTag from "./NewTag";
import EditTag from "./EditTag";
import Pagination from "../../Components/Pagination";
import DeletePrompt from "../../Components/DeletePrompt";
import DeleteBulkPrompt from "../../Components/DeleteBulkPrompt";
import DataTable from "primevue/datatable";
import Filter from "../../Components/Filter";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    tags:Object,
    filters:Object,
    sortables:{
        type:Array,
        default:[]
    }
});

const selectedItems = ref([]);
const metaKey = ref(true);
const selectedTag = ref(null);

const resetSelectedItems = () => {
    selectedItems.value = [];
}

const resetSelectedTag = () => {
    selectedTag.value = null;
}

const hasConnectedLanguage = (content,lang) => {

    let data = null;
    const dfilter = content.connected_tags.filter((x) => x.language == lang);

    if( dfilter.length ){
        data = dfilter[0];
    }
    return data;

}

</script>