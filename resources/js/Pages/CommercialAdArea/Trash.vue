<template>
    <Head head-key="title" title="Reklam grupları çöp kutusu" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Reklam grupları çöp kutusu
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('commercial-ad-areas.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">
                <div class="card-body p-0">

                    <DataTable :value="props.commercial_ad_areas.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column header="İsim" field="name"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <RestorePrompt :uri="route('commercial-ad-areas.restore',data.id)" :model="data"/>
                                    <DestroyPrompt :uri="route('commercial-ad-areas.destroy',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.commercial_ad_areas.links" :only="['commercial_ad_areas','flash']"/>
                </div>
            </div>

        </div>

    </div>

</template>

<script setup>

import {ref} from "vue";
import Pagination from "../../Components/Pagination";
import DestroyPrompt from "../../Components/DestroyPrompt";
import RestorePrompt from "../../Components/RestorePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';

const props = defineProps({
    commercial_ad_areas:Object,
    filters:Object,
    sortables:{
        type:Array,
        default:[]
    }
});

const metaKey = ref(true);


</script>