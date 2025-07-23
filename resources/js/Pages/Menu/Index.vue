<template>
    <Head head-key="title" title="Menü Tipleri" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <PageTitleWithLanguage :routeName="'menus.index'" :title="'Menü'"/>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-header px-4">
                    <div class="card-toolbar w-100 justify-content-between gap-2">
                        <Link :href="route('menus.create',{language:$page.props.current_language})" class="btn fw-bold btn-sm btn-success d-flex align-items-center">
                            <i class="bi bi-plus-circle fs-4"></i>
                            <span class="ms-1 lh-1">YENİ</span>
                        </Link>
                    </div>
                </div>

                <div class="card-body p-0">

                    <DataTable :value="props.menus" stripedRows dataKey="id" tableStyle="min-width: 50rem">
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
                        <Column field="name" header="İsim"></Column>
                        <Column field="language" header="Dil"></Column>
                        <Column field="location" header="Lokasyon"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Link :href="route('menus.edit',[data,{language:data.language}])">
                                        <Button icon="bi bi-pencil" text rounded severity="info" class="ms-2"/>
                                    </Link>
                                    <DeletePrompt :uri="route('menus.destroy',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

    </div>

</template>

<script setup>

import PageTitleWithLanguage from "../../Components/PageTitleWithLanguage";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from 'primevue/button';

const props = defineProps({
    menus:Object
});

</script>