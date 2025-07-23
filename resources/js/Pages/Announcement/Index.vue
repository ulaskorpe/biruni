<template>
    <Head head-key="title" title="Duyurular" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <PageTitleWithLanguage :routeName="'announcements.index'" :title="'Duyuru'"/>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-header px-4">
                    <div class="card-toolbar w-100 justify-content-between gap-2">
                        <NewAnnouncement :language="$page.props.current_language"/>
                    </div>
                </div>

                <div class="card-header px-4">
                    <Filter :filters="props.filters" :uri="route('announcements.index')" />
                </div>
                <div class="card-body p-0">

                    <DataTable :value="props.announcements.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
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
                        <Column header="Bağlı Diller">
                            <template #body="{ data }">
                                <div class="hstack gap-2">
                                    <div v-for="(lang,key) in $page.props.languages.active.filter((l) => l != data.language)" :key="key">
                                        <NewAnnouncement :button-class="'btn fw-bold btn-sm btn-icon btn-light-danger text-uppercase'" :button-text="lang" :language="lang" :from-announcement="data" v-if="!hasConnectedLanguage(data,lang)" v-tooltip.top="'Oluştur'"/>
                                        <button type="button" v-if="hasConnectedLanguage(data,lang)" @click="selectedAnnouncement = hasConnectedLanguage(data,lang)" class="btn fw-bold btn-sm btn-icon btn-light-info text-uppercase" v-tooltip.top="'Güncelle'">{{ lang }}</button>
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column field="users_only" header="Sadece Üyeler"></Column>
                        <Column field="name" header="Adı"></Column>
                        <Column field="description" header="Duyuru"></Column>
                        <Column field="start_date" header="Başlangıç">
                            <template #body="{ data }">
                                <span v-html="formatDateToMask(data.start_date)"></span>
                            </template>
                        </Column>
                        <Column field="end_date" header="Bitiş">
                            <template #body="{ data }">
                                <span v-html="formatDateToMask(data.end_date)"></span>
                            </template>
                        </Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pen" text rounded severity="info" @click="selectedAnnouncement = data" v-tooltip.top="'Güncelle'"/>
                                    <DeletePrompt :uri="route('announcements.delete',[data.id,{language:data.language}])" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.announcements.links" :only="['announcements','flash']"/>
                </div>
            </div>

        </div>

    </div>

    <EditAnnouncement :announcement="selectedAnnouncement" v-tooltip.top="'Güncelle'" :on-hide="resetSelectedAnnouncement" v-if="selectedAnnouncement"/>

</template>

<script setup>

import { ref } from "vue";

import PageTitleWithLanguage from "../../Components/PageTitleWithLanguage";

import NewAnnouncement from "./NewAnnouncement";
import EditAnnouncement from "./EditAnnouncement";
import Pagination from "../../Components/Pagination";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from 'primevue/button'
import Filter from "../../Components/Filter";

const props = defineProps({
    announcements:Object,
    filters:Object,
    sortables:{
        type:Array,
        default:[]
    }
});

const selectedAnnouncement = ref(null);

const resetSelectedAnnouncement = () => {
    selectedAnnouncement.value = null;
}

const hasConnectedLanguage = (content,lang) => {

    let data = null;
    const dfilter = content.connected_announcements.filter((x) => x.language == lang);

    if( dfilter.length ){
        data = dfilter[0];
    }
    return data;

}

const formatDateToMask = (date) => {
    var originalDate = new Date(date);
    var day = originalDate.getDate().toString().padStart(2, '0');
    var month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Ay 0-11 arasında olduğu için +1 ekliyoruz.
    var year = originalDate.getFullYear();

    return day + '.' + month + '.' + year;
}

</script>