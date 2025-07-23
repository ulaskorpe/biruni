<template>
    <Head head-key="title" title="İçerik Tipleri" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <PageTitleWithLanguage :routeName="'content-types.index'" :title="'İçerik Tipi'"/>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-header px-4">
                    <div class="card-toolbar w-100 justify-content-between gap-2">
                        <NewContentType :layouts="props.layouts" :language="$page.props.current_language"/>
                    </div>
                </div>

                <div class="card-body p-0">

                    <DataTable :value="$page.props.contentTypes" stripedRows dataKey="id" tableStyle="min-width: 50rem">
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
                                        <NewContentType :button-class="'btn fw-bold btn-sm btn-icon btn-light-danger text-uppercase'" :button-text="lang" :layouts="props.layouts" :language="lang" :from-content-type="data" v-if="!hasConnectedLanguage(data,lang)" v-tooltip.top="'Oluştur'"/>
                                        <button type="button" v-if="hasConnectedLanguage(data,lang)" @click="selectedContentType = hasConnectedLanguage(data,lang)" class="btn fw-bold btn-sm btn-icon btn-light-info text-uppercase" v-tooltip.top="'Güncelle'">{{ lang }}</button>
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column field="name" header="İsim"></Column>
                        <Column field="slug" header="Slug"></Column>
                        <Column header="URL">
                            <template #body="{ data }">
                                {{ data.has_url }}
                            </template>
                        </Column>
                        <Column header="Kategori">
                            <template #body="{ data }">
                                {{ data.has_category }}
                            </template>
                        </Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-pen" text rounded severity="info" @click="selectedContentType = data" v-tooltip.top="'Güncelle'"/>
                                    <DeletePrompt :uri="route('content-types.delete',[data.id,{language:$page.props.current_language}])" :model="data" v-if="data.is_deletable"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

    </div>

    <EditContentType :content-type="selectedContentType" :layouts="props.layouts" :on-hide="resetSelectedContentType" v-if="selectedContentType"/>

</template>

<script setup>

import {ref} from "vue";
import PageTitleWithLanguage from "../../Components/PageTitleWithLanguage";

import NewContentType from "./NewContentType";
import EditContentType from "./EditContentType";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    layouts:Object
});

const selectedContentType = ref(null);

const resetSelectedContentType = () => {
    selectedContentType.value = null;
}

const hasConnectedLanguage = (content,lang) => {

    let data = null;
    const dfilter = content.connected_content_types.filter((x) => x.language == lang);

    if( dfilter.length ){
        data = dfilter[0];
    }
    return data;

}

</script>