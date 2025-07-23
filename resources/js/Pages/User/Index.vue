<template>
    <Head head-key="title" title="Kullanıcı Yönetimi" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Kullanıcı Yönetimi
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('users.trash')" class="btn fw-bold btn-sm btn-light-danger btn-icon ms-auto" v-tooltip.top="'Çöp Kutusu'">
                    <i class="bi bi-trash fs-4"></i>
                </Link>
                <Link :href="route('users.create')" class="btn fw-bold btn-sm btn-success d-flex align-items-center">
                    <i class="bi bi-plus-circle fs-4"></i>
                    <span class="ms-1 lh-1">YENİ</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">
                <div class="card-header px-4" v-if="selectedItems.length === 0">
                    <Filter :filters="props.filters" :uri="route('users.index')" />
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-person me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <DeleteBulkPrompt :uri="route('users.bulk.delete')" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" :value="props.users.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column header="Durum">
                            <template #body="{ data }">
                                <i class="bi bi-check-circle-fill text-success fs-2" v-if="data.approval_status === 1" v-tooltip.top="'Onaylanmış'"></i>
                                <i class="bi bi-x-circle-fill text-danger fs-2" v-if="data.approval_status === 2" v-tooltip.top="'İptal'"></i>
                                <i class="bi bi-pause-circle-fill text-warning fs-2" v-if="data.approval_status === 0" v-tooltip.top="'Yeni'"></i>
                            </template>
                        </Column>
                        <Column field="name" header="İsim">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap align-items-center">
                                    <div>
                                        <Avatar :image="data.avatar_preview_url" class="" size="large" shape="circle" v-if="data.avatar_preview_url" />
                                        <Avatar icon="bi bi-person" size="large" shape="circle" v-else/>
                                    </div>
                                    <span class="ms-3">{{ data.name }}</span>
                                </div>
                            </template>
                        </Column>
                        <Column field="email" header="E-Posta"></Column>
                        <Column header="Roller">
                            <template #body="{ data }">
                                <span v-for="(role,r) in data.roles" :key="r"><span v-if="r > 0">, </span>{{ role.view_name }}</span>
                            </template>
                        </Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Link :href="route('users.edit',data.id)">
                                        <Button icon="bi bi-pencil" text rounded severity="info" class="ms-2"/>
                                    </Link>
                                    <DeletePrompt :delete-done="resetSelectedItems" :uri="route('users.delete',data.id)" :model="data"/>
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

import {ref,provide, onMounted} from "vue";
import Pagination from "../../Components/Pagination";
import DeletePrompt from "../../Components/DeletePrompt";
import DeleteBulkPrompt from "../../Components/DeleteBulkPrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Avatar from 'primevue/avatar';
import Button from "primevue/button";
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