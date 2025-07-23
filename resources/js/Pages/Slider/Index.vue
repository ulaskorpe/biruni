<template>
    <Head head-key="title" title="Slider Yönetimi" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Slider Yönetimi
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <NewSlider />
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card">

                <div class="card-body p-0">

                    <DataTable :value="props.sliders" stripedRows sortMode="single" dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="name" header="İsim"></Column>
                        <Column class="text-end">
                            <template #body="{ data }">
                                <div class="d-flex flex-nowrap justify-content-end">
                                    <Button icon="bi bi-gear" rounded severity="success" @click="selectedSliderForSlides = data" v-tooltip.top="'Slide Listesi'"/>
                                    <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="selectedSlider = data" class="ms-2"/>
                                    <DeletePrompt :uri="route('sliders.delete',data.id)" :model="data"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </div>
            </div>

        </div>

    </div>

    <EditSlider :selected-slider="selectedSlider" :on-update-done="resetselectedSlider" v-if="selectedSlider" />
    <Slides :selected-slider="selectedSliderForSlides" :on-hide="resetselectedSliderForSlides" v-if="selectedSliderForSlides"/>

</template>

<script setup>

import {ref} from "vue";
import NewSlider from "./NewSlider";
import EditSlider from "./EditSlider";
import Slides from "./Slides";
import DeletePrompt from "../../Components/DeletePrompt";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Button from "primevue/button";

const props = defineProps({
    sliders:Object
});

const metaKey = ref(true);
const selectedSlider = ref(null);
const selectedSliderForSlides = ref(null);

const resetselectedSlider = () => {
    selectedSlider.value = null;
}
const resetselectedSliderForSlides = () => {
    selectedSliderForSlides.value = null;
}

</script>