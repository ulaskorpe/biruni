<template>
    <Head head-key="title" :title="`${props.content_type.name} çöp kutusu`" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ props.content_type.name }} çöp kutusu
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('contents.index',{contentType:props.content_type.id,language:$page.props.current_language})" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">
                <div class="card-header px-4" v-if="selectedItems.length === 0">
                    <Filter :filters="props.filters" :uri="route('contents.trash')" :extra-params="`contentType=${props.content_type.id}`"/>
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-check2-circle me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <RestoreBulkPrompt :uri="route('contents.bulk.restore',{language:$page.props.current_language, contentType:props.content_type.id})" :items="selectedItems" :restore-done="resetSelectedItems"/>
                        <DestroyBulkPrompt :uri="route('contents.bulk.destroy',{language:$page.props.current_language, contentType:props.content_type.id})" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" :value="props.content_type.has_category ? props.contents.data : props.contents" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column header="İsim">
                            <template #body="{ data }">
                                <span v-html="props.content_type.has_category ? data.name : data.depth_name"></span>
                            </template>
                        </Column>
                        <Column field="slug" header="Slug"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <RestorePrompt :restore-done="resetSelectedItems" :uri="route('contents.restore',[data.id,{language:$page.props.current_language, contentType:props.content_type.id}])" :model="data"/>
                                    <DestroyPrompt :delete-done="resetSelectedItems" :uri="route('contents.destroy',[data.id,{language:$page.props.current_language,contentType:props.content_type.id}])" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

        <div class="p-5 my-10 position-sticky bottom-0 bg-light" v-if="content_type.has_category">
            <PaginationSticky :links="props.contents.links" :only="['contents','flash']"/>
        </div>

    </div>

</template>

<script setup>

import {ref} from "vue";
import PaginationSticky from "../../Components/PaginationSticky";
import DestroyPrompt from "../../Components/DestroyPrompt";
import RestorePrompt from "../../Components/RestorePrompt";
import DestroyBulkPrompt from "../../Components/DestroyBulkPrompt";
import RestoreBulkPrompt from "../../Components/RestoreBulkPrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Filter from "../../Components/Filter";

const props = defineProps({
    contents:Object,
    content_type:Object,
    filters:Object,
    sortables:{
        type:Array,
        default:[]
    }
});

const selectedItems = ref([]);
const metaKey = ref(true);

const resetSelectedItems = () => {
    selectedItems.value = [];
}

</script>