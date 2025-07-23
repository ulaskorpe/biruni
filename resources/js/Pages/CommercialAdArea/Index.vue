<template>
    <Head head-key="title" title="Reklam Grupları Yönetimi" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0 text-uppercase">
                    <span class="d-flex align-items-center">Reklam Grupları</span>
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('commercial-ad-areas.trash')" class="btn fw-bold btn-sm btn-light-danger btn-icon ms-auto" v-tooltip.top="'Çöp Kutusu'">
                    <i class="bi bi-trash fs-4"></i>
                </Link>
                <Create />
            </div>
        </div>
    </div>

	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <div class="card">

                <div class="card-body p-0">

                    <DataTable :value="props.commercial_ad_areas" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="id" header="ID" headerStyle="width: 4rem" sortable></Column>
                        <Column field="name" header="İsim" sortable></Column>
                        <Column field="commercial_ads_count" header="Reklam Adeti" sortable></Column>
                        <Column class="text-end border-start" frozen alignFrozen="right" header="İşlemler">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pen" text rounded severity="info" @click="selectedAttribute = data" v-tooltip.top="'Güncelle'"/>
                                    <DeletePrompt :uri="route('commercial-ad-areas.delete',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

    </div>

    <Edit :item="selectedAttribute" :on-hide="resetSelectedAttribute" v-if="selectedAttribute"/>

</template>

<script setup>

import {ref} from "vue";

import Create from "./Create";
import Edit from "./Edit";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    commercial_ad_areas:Object,
    filters:Object
});

const metaKey = ref(true);

const selectedAttribute = ref(null);

const resetSelectedAttribute = () => {
    selectedAttribute.value = null;
}

</script>