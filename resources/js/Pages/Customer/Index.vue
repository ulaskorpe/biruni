<template>
    <Head head-key="title" title="Üye Yönetimi" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Üye Yönetimi
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('customers.trash')" class="btn fw-bold btn-sm btn-light-danger ms-auto d-flex align-items-center" v-tooltip.top="'Çöp Kutusu'">
                    <i class="bi bi-trash fs-4"></i>
                    <span>Çöp Kutusu</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">
                <div class="card-header px-4" v-if="selectedItems.length === 0">
                    <Filter :filters="props.filters" :uri="route('customers.index')" :has-export="true"/>
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-person me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <DeleteBulkPrompt :uri="route('customers.bulk.delete')" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" :value="props.users.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column field="name" header="İsim">
                            <template #body="{ data }">
                                <Link :href="route('customers.show',data)">
                                    <div class="d-flex flex-nowrap align-items-center">
                                        <div>
                                            <Avatar :image="data.avatar_preview_url" class="" size="large" shape="circle" v-if="data.avatar_preview_url" />
                                            <Avatar icon="bi bi-person" size="large" shape="circle" v-else/>
                                        </div>
                                        <span class="ms-3">{{ data.name }}</span>
                                    </div>
                                </Link>
                            </template>
                        </Column>
                        <Column field="email" header="E-Posta"></Column>
                        <Column field="phone" header="Telefon"></Column>
                        <Column field="created_at" header="Üyelik Tarihi"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
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

import {ref} from "vue";
import Pagination from "../../Components/Pagination";
import DeletePrompt from "../../Components/DeletePrompt";
import DeleteBulkPrompt from "../../Components/DeleteBulkPrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Avatar from 'primevue/avatar';
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

const refreshUser = (user) => {
    let tableUser = props.users.data.find(x => x.id == user.id);
    Object.assign(tableUser, user);
}

const resetSelectedItems = () => {
    selectedItems.value = [];
}

</script>