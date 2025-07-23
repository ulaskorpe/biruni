<template>

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CONTAINER ID</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedContainer.settings.id" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CONTAINER NAME</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedContainer.settings.name" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">DISPLAY</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="hstack gap-5">
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedContainer.settings.display.mobile" />
                            <label class="fw-bold ms-2">Mobile</label>
                        </div>
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedContainer.settings.display.desktop" />
                            <label class="fw-bold ms-2">Desktop</label>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">FULL WIDTH</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputSwitch v-model="selectedContainer.settings.fullWidth" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ROWS AS TAB</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputSwitch v-model="selectedContainer.settings.rowsAsTabs" />
                </div>
            </div>

            <Divider />

            <div v-if="!selectedContainer.settings.fullWidth">
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">EXTRA LARGE</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedContainer.settings.largeContainer" />
                    </div>
                </div>

                <Divider />
            </div>

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">PADDING</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-up"></i></span>
                                <Dropdown v-model="selectedContainer.settings.padding.top" :options="containerSettingOptions.padding.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedContainer.settings.padding.right" :options="containerSettingOptions.padding.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedContainer.settings.padding.bottom" :options="containerSettingOptions.padding.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedContainer.settings.padding.left" :options="containerSettingOptions.padding.left" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">MARGIN</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-up"></i></span>
                                <Dropdown v-model="selectedContainer.settings.margin.top" :options="containerSettingOptions.margin.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedContainer.settings.margin.right" :options="containerSettingOptions.margin.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedContainer.settings.margin.bottom" :options="containerSettingOptions.margin.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedContainer.settings.margin.left" :options="containerSettingOptions.margin.left" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ROUNDED</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedContainer.settings.rounded" :options="containerSettingOptions.rounded" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND COLOR</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedContainer.settings.background.color" :options="containerSettingOptions.background.color" filter optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="d-flex flex-row flex-wrap align-items-end">
                        <img :src="selectedContainer.settings.background.image" v-if="selectedContainer.settings.background.image" class="img-thumbnail me-2" width="200"/>
                        <div class="d-flex flex-row align-items-center">
                            <PopupMediaLibrary v-if="!selectedContainer.settings.background.image" :on-select="setContainerBgImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                            <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="selectedContainer.settings.background.image" @click="selectedContainer.settings.background.image = null">
                                <i class="bi bi-x fs-3"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE POSITION</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedContainer.settings.background.position" :options="containerSettingOptions.background.position" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND SIZE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedContainer.settings.background.size" :options="containerSettingOptions.background.size" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE LAYER</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <Dropdown v-model="selectedContainer.settings.background.layer.color" :options="containerSettingOptions.background.layer.color" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                        <div class="col-6">
                            <Dropdown v-model="selectedContainer.settings.background.layer.opacity" :options="containerSettingOptions.background.layer.opacity" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CUSTOM CLASS</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedContainer.settings.class" class="w-100" />
                </div>
            </div>

            <div class="mt-10 rounded p-3 bg-light border d-flex justify-content-end">
                <Button label="Tamam" @click="props.hideSettings" />
            </div>

</template>

<script setup>

import {ref} from "vue";

import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";


import {containerSettingOptions} from "./design-elements-data.js";
const props = defineProps({
    container:Object,
    hideSettings:Function
});

const selectedContainer = ref(props.container);

const setContainerBgImage = (media) => {
    selectedContainer.value.settings.background.image = media.original_url;
}

</script>