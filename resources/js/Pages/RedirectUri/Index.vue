<template>
    <Head head-key="title" title="Yönlendirme Kuralları" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Yönlendirme Kuralları
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <NewRedirectUri :app-url="props.app_url"/>
            </div>

        </div>
    </div>
	
    
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <div class="card">

                <div class="card-body p-0">

                    <DataTable :value="props.redirect_uris.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column field="old" header="URL"></Column>
                        <Column field="new" header="Yönlendirilen URL"></Column>
                        <Column field="redirect_type" header="Kural"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="selectedRedirectUri = data"/>
                                    <DeletePrompt :delete-done="resetSelectedItems" :uri="route('redirect-uris.destroy',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>

                <div class="card-footer">
                    <Pagination :links="props.redirect_uris.links" :only="['redirect_uris','flash']"/>
                </div>

            </div>

        </div>

    </div>

    <EditRedirectUri :selected-redirect-uri="selectedRedirectUri" :app-url="props.app_url" :on-update-done="resetselectedRedirectUri" v-if="selectedRedirectUri" />

</template>

<script setup>

import {ref} from "vue";

import Pagination from "../../Components/Pagination";
import NewRedirectUri from "./NewRedirectUri";
import EditRedirectUri from "./EditRedirectUri";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    redirect_uris:Object,
    app_url:String
});

const selectedItems = ref([]);
const metaKey = ref(true);
const selectedRedirectUri = ref(null);

const resetSelectedItems = () => {
    selectedItems.value = [];
}

const resetselectedRedirectUri = () => {
    selectedRedirectUri.value = null;
}

</script>