<template>
    <Head head-key="title" title="Rol Yönetimi" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Rol Yönetimi
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <NewRole />
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-body p-0">

                    <DataTable :value="props.roles" stripedRows sortMode="single" dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="view_name" header="İsim"></Column>
                        <Column field="description" header="Açıklama"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end" v-if="data.name != 'super-admin'">
                                    <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="selectedRole = data" class="ms-2"/>
                                    <DeletePrompt :uri="route('roles.destroy',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

    </div>

    <EditRole :selected-role="selectedRole" :on-update-done="resetselectedRole" v-if="selectedRole" />

</template>

<script setup>

import {ref} from "vue";
import NewRole from "./NewRole";
import EditRole from "./EditRole";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    roles:Object
});

const metaKey = ref(true);
const selectedRole = ref(null);

const resetselectedRole = () => {
    selectedRole.value = null;
}

</script>