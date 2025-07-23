<template>

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">Column ID</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedColumn.settings.id" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">Column Name</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedColumn.settings.name" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">DISPLAY</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="hstack gap-5">
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedColumn.settings.display.mobile" />
                            <label class="fw-bold ms-2">Mobile</label>
                        </div>
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedColumn.settings.display.desktop" />
                            <label class="fw-bold ms-2">Desktop</label>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">Column SIZE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">SM</span>
                                <Dropdown v-model="selectedColumn.settings.size.sm" :options="columnSettingOptions.size.sm" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">MD</span>
                                <Dropdown v-model="selectedColumn.settings.size.md" :options="columnSettingOptions.size.md" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">LG</span>
                                <Dropdown v-model="selectedColumn.settings.size.lg" :options="columnSettingOptions.size.lg" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">XL</span>
                                <Dropdown v-model="selectedColumn.settings.size.xl" :options="columnSettingOptions.size.xl" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">PADDING</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-up"></i></span>
                                <Dropdown v-model="selectedColumn.settings.padding.top" :options="columnSettingOptions.padding.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedColumn.settings.padding.right" :options="columnSettingOptions.padding.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedColumn.settings.padding.bottom" :options="columnSettingOptions.padding.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedColumn.settings.padding.left" :options="columnSettingOptions.padding.left" optionValue="value" optionLabel="label" class="w-100" />
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
                                <Dropdown v-model="selectedColumn.settings.margin.top" :options="columnSettingOptions.margin.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedColumn.settings.margin.right" :options="columnSettingOptions.margin.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedColumn.settings.margin.bottom" :options="columnSettingOptions.margin.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedColumn.settings.margin.left" :options="columnSettingOptions.margin.left" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">Content Flex DIRECTION</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">SM</span>
                                <Dropdown v-model="selectedColumn.settings.flexDirection.sm" showClear :options="columnSettingOptions.flexDirection.sm" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">MD</span>
                                <Dropdown v-model="selectedColumn.settings.flexDirection.md" showClear :options="columnSettingOptions.flexDirection.md" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">LG</span>
                                <Dropdown v-model="selectedColumn.settings.flexDirection.lg" showClear :options="columnSettingOptions.flexDirection.lg" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon">XL</span>
                                <Dropdown v-model="selectedColumn.settings.flexDirection.xl" showClear :options="columnSettingOptions.flexDirection.xl" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ROUNDED</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedColumn.settings.rounded" :options="columnSettingOptions.rounded" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND COLOR</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedColumn.settings.background.color" :options="columnSettingOptions.background.color" filter optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div v-if="props.layoutMode">
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">DYNAMIC BACKGROUND</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedColumn.settings.background.dynamic" />
                    </div>
                </div>
                <Divider />
                <div v-if="selectedColumn.settings.background.dynamic">
                    <div class="row align-items-center">
                        <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE</label>
                        <div class="col-md-6 col-lg-8 col-xl-6">
                            <Dropdown v-model="selectedColumn.settings.background.dynamic_image" :options="columnSettingOptions.background.dynamic" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <Divider />
                </div>
            </div>

            <div v-if="!selectedColumn.settings.background.dynamic">
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <div class="d-flex flex-row flex-wrap align-items-end">
                            <img :src="selectedColumn.settings.background.image" v-if="selectedColumn.settings.background.image" class="img-thumbnail me-2" width="200"/>
                            <div class="d-flex flex-row align-items-center">
                                <PopupMediaLibrary v-if="!selectedColumn.settings.background.image" :on-select="setColumnBgImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="selectedColumn.settings.background.image" @click="selectedColumn.settings.background.image = null">
                                    <i class="bi bi-x fs-3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />
            </div>

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE POSITION</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedColumn.settings.background.position" :options="columnSettingOptions.background.position" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND SIZE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedColumn.settings.background.size" :options="columnSettingOptions.background.size" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE LAYER</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <Dropdown v-model="selectedColumn.settings.background.layer.color" :options="columnSettingOptions.background.layer.color" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                        <div class="col-6">
                            <Dropdown v-model="selectedColumn.settings.background.layer.opacity" :options="columnSettingOptions.background.layer.opacity" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">Sticky</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputSwitch v-model="selectedColumn.settings.sticky" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CUSTOM CLASS</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedColumn.settings.class" class="w-100" />
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


import {columnSettingOptions} from "./design-elements-data.js";
const props = defineProps({
    column:Object,
    hideSettings:Function,
    layoutMode:{
        type:Boolean,
        default:false
    }
});

const selectedColumn = ref(props.column);

const setColumnBgImage = (media) => {
    selectedColumn.value.settings.background.image = media.original_url;
}

</script>