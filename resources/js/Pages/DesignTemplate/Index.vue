<template>
    <Head head-key="title" title="Hazır Tasarım Şablonları" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Hazır Tasarım Şablonları
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('design-templates.create')" class="btn fw-bold btn-sm btn-success d-flex align-items-center">
                    <i class="bi bi-plus-circle fs-4"></i>
                    <span class="ms-1 lh-1">EKLE</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">
                <div class="card-body p-0">

                    <DataTable :value="props.templates.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column field="name" header="İsim"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Link :href="route('design-templates.edit',data.id)">
                                        <Button icon="bi bi-pencil" text rounded severity="info" class="ms-2"/>
                                    </Link>
                                    <DeletePrompt :uri="route('design-templates.delete',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.templates.links" :only="['templates','flash']"/>
                </div>
            </div>

        </div>

    </div>

</template>

<script setup>

import Pagination from "../../Components/Pagination";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from 'primevue/button';

const props = defineProps({
    templates:Object,
});


</script>