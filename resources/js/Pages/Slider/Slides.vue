<template>
    
    <div>

        <Dialog @hide="hide" v-model:visible="visible" modal :header="`${props.selectedSlider.name} Slide Listesi`" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">

            <div class="mb-5">
                <SlideNew :slider="props.selectedSlider" :store-done="addToSlidesList"/>
            </div>
            <DataTable :value="slides" @rowReorder="onRowReorder" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                <Column rowReorder headerStyle="width: 3rem" :reorderableColumn="false" />
                <Column headerStyle="width: 4rem">
                    <template #body="{ data }">
                        <div class="symbol symbol-50px">
                            <img :src="data.image.preview_url" v-if="data.image"/>
                            <div class="symbol-label" v-else>
                                <i class="bi bi-person fs-2x"></i>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column field="title" header="Başlık"></Column>
                <Column class="text-end">
                    <template #body="{ data }">
                        <div class="d-flex flex-nowrap justify-content-end">
                            <SlideEdit :slider="props.selectedSlider" :slide="data" :update-done="refreshUpdatedItem"/>
                            <DeletePrompt :uri="route('slider-slides.delete',data)" :model="data" :delete-done="removeDeletedItem"/>
                        </div>
                    </template>
                </Column>
            </DataTable>

        </Dialog>
    </div>

</template>

<script setup>

import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import Button from 'primevue/button';
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import SlideNew from "./SlideNew";
import SlideEdit from "./SlideEdit";
import DeletePrompt from "../../Components/DeletePrompt";

const props = defineProps({
    selectedSlider:Object,
    onHide:{
        type:Function,
        default:() => {}
    }
});

const visible = ref(true);
const slides = ref(props.selectedSlider.slides);

const hide = () => {
    props.onHide();
    visible.value = false;
}

const addToSlidesList = (slide) => {
    slides.value = [...slides.value, slide];
}

const refreshUpdatedItem = (slide) => {
    let item = slides.value.find(x => x.id == slide.id);
    Object.assign(item, slide);
}

const removeDeletedItem = (slide) => {
    let slideIndex = slides.value.indexOf(slide);
    slides.value.splice(slideIndex,1);
}

const onRowReorder = (event) => {
    slides.value = event.value;

    (async () => {
        const rawResponse = await fetch(route('slider-slides.reorder'), {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': usePage().props.csrf_token
            },
            body: JSON.stringify({
                data:slides.value.map((row) => row.id),
            })
        });
        const response = await rawResponse.json();
        console.log(response);
    })();

}

</script>