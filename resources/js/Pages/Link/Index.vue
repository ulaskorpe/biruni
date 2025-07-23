<template>
    <Head head-key="title" title="URL Yönetimi" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    URL Yönetimi
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">

            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <div class="card">

                <div class="card-header px-4">
                    <Filter :filters="props.filters" :uri="route('links.index')" />
                </div>

                <div class="card-body p-0">

                    <DataTable :value="props.links.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column header="Dil" headerStyle="width: 4rem">
                            <template #body="{ data }">
                                <div class="d-flex align-items-center">
                                    <img :src="`/dmn/media/flags/${data.language}.svg`" class="me-2" style="width: 14px" />
                                    <span class="text-uppercase">{{ data.language }}</span>
                                </div>
                            </template>
                        </Column>
                        <Column header="İsim">
                            <template #body="{ data }">
                                <span>{{ data.linkable.name }}</span>
                            </template>
                        </Column>
                        <Column field="linkable_type" header="Model"></Column>
                        <Column field="final_uri" header="URL"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pen" text rounded severity="info" @click="selectedLink = data" v-tooltip.top="'Güncelle'"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.links.links" :only="['links','flash']"/>
                </div>

            </div>

        </div>

    </div>

    <Edit :link="selectedLink" :on-done="resetAll" v-if="selectedLink"/>

</template>

<script setup>

import {ref} from "vue";

import Edit from "./Edit";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

import Filter from "../../Components/Filter";
import Pagination from "../../Components/Pagination";

const props = defineProps({
    links:Object,
    filters:Object
});

const selectedLink = ref(null);

const resetAll = () => {
    selectedLink.value = null;
}


</script>