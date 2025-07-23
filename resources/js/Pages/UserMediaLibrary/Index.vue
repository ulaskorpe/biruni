<template>
    <Head head-key="title" title="Medya Kütüphanem" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Medya Kütüphanem
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <UploadFilesDropzone />
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container  container-xxl">
            
            <div class="card">
                <div class="card-header px-4" v-if="selectedItems.length === 0">
                    <div class="card-toolbar">
                        <input type="text" class="form-control form-control-sm" placeholder="Ara..." v-model="params.search">
                    </div>
                </div>
                <div class="card-header px-4" v-if="selectedItems.length > 0">
                    <h5 class="card-title fs-6"><i class="bi bi-check2-circle me-2 fs-2"></i>{{ selectedItems.length }}</h5>
                    <div class="card-toolbar">
                        <DeleteBulkPrompt :uri="route('user-medias.bulk.delete')" :items="selectedItems" :message="'Seçilen kayıtlar tamamen silinecek. Bu işlem geri alınamaz!'"/>
                    </div>
                </div>
                <div class="card-body p-0">

                    <DataTable v-model:selection="selectedItems" :value="props.user_medias.data" scrollable scrollHeight="flex" dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column headerStyle="width: 7.5rem">
                            <template #body="{ data }">
                                <DeferredContent v-if="data.mime_type.startsWith('image/')">
                                    <a class="symbol symbol-75px bg-light" data-fancybox="gallery" :href="data.original_url">
                                        <img :src="data.preview_url" alt="" v-if="data.preview_url"/>
                                        <img :src="data.original_url" alt="" v-else/>
                                    </a>
                                </DeferredContent>
                                <div v-else>
                                    <a href="#" class="symbol symbol-75px" v-if="data.custom_properties.ext == 'pdf'" data-fancybox="gallery" :data-src="data.original_url" data-type="pdf">
                                        <div class="symbol-label">
                                            <IconByExt :ext="data.custom_properties.ext" :size="'2x'"/>
                                        </div>
                                    </a>

                                    <a class="symbol symbol-75px" v-else-if="data.mime_type.startsWith('video/')" data-fancybox="gallery" :href="data.original_url">
                                        <div class="symbol-label">
                                            <IconByExt :ext="data.custom_properties.ext" :size="'2x'"/>
                                        </div>
                                    </a>

                                    <a class="symbol symbol-75px" v-else-if="data.mime_type.startsWith('audio/')" data-fancybox="gallery" :href="data.original_url" data-type="html5video">
                                        <div class="symbol-label">
                                            <IconByExt :ext="data.custom_properties.ext" :size="'2x'"/>
                                        </div>
                                    </a>

                                    <div class="symbol symbol-75px" v-else>
                                        <div class="symbol-label">
                                            <IconByExt :ext="data.custom_properties.ext" :size="'2x'"/>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Column>
                        <Column>
                            <template #body="{ data }">
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder fs-4 lh-1 mb-2">{{ data.name }}</span>
                                    <span class="lh-1 mb-1">{{ data.file_name }}</span>
                                    <small class="text-danger">{{ parseInt(data.size / 1000).toFixed() }} KB</small>
                                </div>
                            </template>
                        </Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <EditMedia :media="data" v-tooltip.top="'Güncelle'"/>
                                    <DeletePrompt :delete-done="resetSelectedItems" :uri="route('user-medias.destroy',data.id)" :model="data" :message="'Medya tamamen silinecek. Bu işlem geri alınamaz!'"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.user_medias.links" />
                </div>
            </div>

        </div>
    </div>

</template>

<script setup>

import {ref,reactive,watch, onMounted} from "vue";
import EditMedia from "./EditMedia";
import debounce from "lodash/debounce";
import { router } from '@inertiajs/vue3';
import Pagination from "../../Components/Pagination";
import DeletePrompt from "../../Components/DeletePrompt";
import DeleteBulkPrompt from "../../Components/DeleteBulkPrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import UploadFilesDropzone from './UploadFilesDropzone';
import DeferredContent from 'primevue/deferredcontent';
import IconByExt from "../../Components/IconByExt";

import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

const props = defineProps({
    user_medias:Object,
    filters:Object
});

const selectedItems = ref([]);
const metaKey = ref(true);

const resetSelectedItems = () => {
    selectedItems.value = [];
}

const params = reactive({
    search: props.filters.search,
    field: props.filters.field,
    direction: props.filters.direction,
});

const sort = (field) => {
    params.field = field;
    params.direction = params.direction === 'asc' ? 'desc' : 'asc';
}

watch(() => ([params.search]), debounce(function (){
    let routeParams = {
        search:params.search,
        field:params.field,
        direction:params.direction,
    }
    router.get(route('user-medias.index'),routeParams,
        {
            preserveState: true,
            replace:true,
        }
    );
},500));

onMounted(() => {
    Fancybox.bind('[data-fancybox="gallery"]', {
    //
    });
});

</script>