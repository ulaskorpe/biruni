<template>
    <Head head-key="title" title="Reklam" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <PageTitleWithLanguage :routeName="'commercial-ads.index'" :title="'Reklam'"/>
        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <div class="card">

                <div class="card-header px-4">
                    <div class="card-toolbar w-100 gap-3">
                        <Create :language="$page.props.current_language" :commercial-ad-areas="props.commercial_ad_areas"/>
                        <div class="d-flex flex-grow-1 px-3">
                            <Filter :filters="props.filters" :uri="route('commercial-ads.index')"/>
                        </div>
                        <Link :href="route('commercial-ads.trash',{language:$page.props.current_language})" class="btn fw-bold btn-sm btn-light-danger btn-icon ms-auto" v-tooltip.top="'Çöp Kutusu'">
                            <i class="bi bi-trash fs-4"></i>
                        </Link>
                        <Link :href="route('commercial-ads.reorder',{language:$page.props.current_language})" class="btn fw-bold btn-sm btn-light d-flex align-items-center">
                            <i class="bi bi-sort-down fs-4"></i>
                            <span class="ms-1 lh-1">SIRALA</span>
                        </Link>
                    </div>
                </div>

                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-check2-circle me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <DeleteBulkPrompt :uri="route('commercial-ads.bulk.delete',{language:$page.props.current_language})" :items="selectedItems" :delete-done="resetSelectedItems"/>
                    </div>
                </div>

                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" scrollable :value="props.commercial_ads.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column headerStyle="width: 3rem">
                            <template #body="{ data }">
                                <div v-if="!data.is_published" v-tooltip.top="'Yayıla'">
                                    <PublishPrompt :uri="route('commercial-ads.publish',[data.id,{language:$page.props.current_language}])" :model="data"/>
                                </div>
                                <div v-if="data.is_published" v-tooltip.top="'Yayından Kaldır'">
                                    <UnPublishPrompt :uri="route('commercial-ads.unpublish',[data.id,{language:$page.props.current_language}])" :model="data"/>
                                </div>
                            </template>
                        </Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column field="name" header="İsim"></Column>
                        <Column field="click_count" header="Tıklama Sayısı"></Column>

                        <Column header="Başlangıç">
                            <template #body="{ data }">
                                {{ data.start_at ? formatDateToMask(data.start_at,true) : 'NA' }}
                            </template>
                        </Column>

                        <Column header="Bitiş">
                            <template #body="{ data }">
                                {{ data.end_at ? formatDateToMask(data.end_at,true) : 'NA' }}
                            </template>
                        </Column>
                        
                        <Column class="text-end border-start" frozen alignFrozen="right" header="İşlemler">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pen" text rounded severity="info" @click="selectedAttribute = data" v-tooltip.top="'Güncelle'"/>
                                    <DeletePrompt :uri="route('commercial-ads.delete',[data.id,{language:$page.props.current_language}])" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>

                <div class="card-footer">
                    <Pagination :links="props.commercial_ads.links" :only="['commercial_ads','flash','filters']"/>
                </div>

            </div>

        </div>

    </div>

    <Edit :item="selectedAttribute" :on-hide="resetSelectedAttribute" v-if="selectedAttribute" :commercial-ad-areas="props.commercial_ad_areas"/>

</template>

<script setup>

import {ref} from "vue";

import PageTitleWithLanguage from "../../Components/PageTitleWithLanguage";
import Pagination from "../../Components/Pagination";
import Filter from "../../Components/Filter";
import Create from "./Create";
import Edit from "./Edit";
import DeletePrompt from "../../Components/DeletePrompt";
import DeleteBulkPrompt from "../../Components/DeleteBulkPrompt";
import PublishPrompt from "../../Components/PublishPrompt";
import UnPublishPrompt from "../../Components/UnPublishPrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    commercial_ads:Object,
    filters:Object,
    commercial_ad_areas:Object,
});

const selectedItems = ref([]);
const metaKey = ref(true);

const resetSelectedItems = () => {
    selectedItems.value = [];
}

const selectedAttribute = ref(null);

const resetSelectedAttribute = () => {
    selectedAttribute.value = null;
}

const formatDateToMask = (date, withHour = false) => {

    if(!date) return '';
    
    var originalDate = new Date(date);
    var day = originalDate.getDate().toLocaleString().padStart(2, '0');
    var month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Ay 0-11 arasında olduğu için +1 ekliyoruz.
    var year = originalDate.getFullYear();
    var hour = String(originalDate.getHours()).padStart(2, '0');
    var min = String(originalDate.getMinutes()).padStart(2, '0');
    var sec = String(originalDate.getSeconds()).padStart(2, '0');

    if( withHour ){
        return day + '.' + month + '.' + year + ' ' + hour + ':' + min + ':' + sec;
    }
    return day + '.' + month + '.' + year;
}
</script>