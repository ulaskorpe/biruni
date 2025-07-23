<template>
    <Head head-key="title" title="Üye çöp kutusu" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Üye çöp kutusu
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('customers.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
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
                    <Filter :filters="props.filters" :uri="route('customers.trash')"/>
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-check2-circle me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <RestoreBulkPrompt :uri="route('customers.bulk.restore')" :items="selectedItems" :restore-done="resetSelectedItems"/>
                        <DestroyBulkPrompt :uri="route('customers.bulk.destroy')" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" :value="props.users.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column header="İsim">
                            <template #body="{ data }">
                                <span v-html="data.name"></span>
                            </template>
                        </Column>
                        <Column field="email" header="Email"></Column>
                        <Column field="phone" header="Telefon"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <RestorePrompt :restore-done="resetSelectedItems" :uri="route('customers.restore',data.id)" :model="data"/>
                                    <DestroyPrompt :delete-done="resetSelectedItems" :uri="route('customers.destroy',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.users.links" :only="['users','flash']"/>
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
import DestroyBulkPrompt from "../../Components/DestroyBulkPrompt";
import RestoreBulkPrompt from "../../Components/RestoreBulkPrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Filter from "../../Components/Filter";

const props = defineProps({
    users:Object,
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