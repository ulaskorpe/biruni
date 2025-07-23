<template>

            
            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ROW ID</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedRow.settings.id" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ROW NAME</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedRow.settings.name" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">DISPLAY</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="hstack gap-5">
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedRow.settings.display.mobile" />
                            <label class="fw-bold ms-2">Mobile</label>
                        </div>
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedRow.settings.display.desktop" />
                            <label class="fw-bold ms-2">Desktop</label>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!selectedRow.settings.columnAsSlides">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">COLUMNS AS TAB</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedRow.settings.columnAsTabs" />
                    </div>
                </div>
            </div>

            <div v-if="!selectedRow.settings.columnAsTabs">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">COLUMNS AS SLIDES</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedRow.settings.columnAsSlides" />
                    </div>
                </div>
            </div>

            <div v-if="selectedRow.settings.columnAsSlides">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">PAGINATION</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedRow.settings.swiperOptions.pagination" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">NAVIGATION</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedRow.settings.swiperOptions.navigation" />
                    </div>
                </div>

                <div v-if="selectedRow.settings.swiperOptions.navigation">
                    <Divider />

                    <div class="row align-items-center">
                        <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">NAVIGATION POSITION</label>
                        <div class="col-md-6 col-lg-8 col-xl-6">
                            <Dropdown v-model="selectedRow.settings.swiperOptions.navigationPosition" :options="['navigation-default','navigation-bottom-left','navigation-bottom-right','navigation-top-right']" class="w-100" />
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">LOOP</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedRow.settings.swiperOptions.loop" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SPACE BETWEEN</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputNumber v-model="selectedRow.settings.swiperOptions.spaceBetween" />
                    </div>
                </div>

                <Divider/>
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">NEXT PREV VISIBLE AREA</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <div class="row g-3">
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">SM</span>
                                    <InputNumber v-model="selectedRow.settings.swiperOptions.nextPrevVisibleArea.sm" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">MD</span>
                                    <InputNumber v-model="selectedRow.settings.swiperOptions.nextPrevVisibleArea.md" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">LG</span>
                                    <InputNumber v-model="selectedRow.settings.swiperOptions.nextPrevVisibleArea.lg" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">XL</span>
                                    <InputNumber v-model="selectedRow.settings.swiperOptions.nextPrevVisibleArea.xl" :useGrouping="false" :minFractionDigits="1" :maxFractionDigits="1" class="w-100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ColumnCounts :column-counts="selectedRow.settings.swiperOptions.columnCounts"/>

            </div>


            <div v-if="!selectedRow.settings.columnAsTabs && !selectedRow.settings.columnAsSlides">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">GUTTER</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <div class="row g-3">
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">SM</span>
                                    <Dropdown v-model="selectedRow.settings.gutter.sm" :options="rowSettingOptions.gutter.sm" optionValue="value" optionLabel="label" class="w-100" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">MD</span>
                                    <Dropdown v-model="selectedRow.settings.gutter.md" :options="rowSettingOptions.gutter.md" optionValue="value" optionLabel="label" class="w-100" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">LG</span>
                                    <Dropdown v-model="selectedRow.settings.gutter.lg" :options="rowSettingOptions.gutter.lg" optionValue="value" optionLabel="label" class="w-100" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="p-inputgroup flex-1">
                                    <span class="p-inputgroup-addon">XL</span>
                                    <Dropdown v-model="selectedRow.settings.gutter.xl" :options="rowSettingOptions.gutter.xl" optionValue="value" optionLabel="label" class="w-100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">MASONRY</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedRow.settings.masonry" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ALIGN ITEMS</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedRow.settings.alignContents" :options="rowSettingOptions.alignContents" showClear optionValue="value" optionLabel="label" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">JUSTIFY CONTENTS</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedRow.settings.justifyContents" :options="rowSettingOptions.justifyContents" showClear optionValue="value" optionLabel="label" class="w-100" />
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
                                <Dropdown v-model="selectedRow.settings.margin.top" :options="rowSettingOptions.margin.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedRow.settings.margin.right" :options="rowSettingOptions.margin.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedRow.settings.margin.bottom" :options="rowSettingOptions.margin.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedRow.settings.margin.left" :options="rowSettingOptions.margin.left" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">ROUNDED</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedRow.settings.rounded" :options="rowSettingOptions.rounded" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND COLOR</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedRow.settings.background.color" :options="rowSettingOptions.background.color" filter optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="d-flex flex-row flex-wrap align-items-end">
                        <img :src="selectedRow.settings.background.image" v-if="selectedRow.settings.background.image" class="img-thumbnail me-2" width="200"/>
                        <div class="d-flex flex-row align-items-center">
                            <PopupMediaLibrary v-if="!selectedRow.settings.background.image" :on-select="setRowBgImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                            <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="selectedRow.settings.background.image" @click="selectedRow.settings.background.image = null">
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
                    <Dropdown v-model="selectedRow.settings.background.position" :options="rowSettingOptions.background.position" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND SIZE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedRow.settings.background.size" :options="rowSettingOptions.background.size" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE LAYER</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <Dropdown v-model="selectedRow.settings.background.layer.color" :options="rowSettingOptions.background.layer.color" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                        </div>
                        <div class="col-6">
                            <Dropdown v-model="selectedRow.settings.background.layer.opacity" :options="rowSettingOptions.background.layer.opacity" optionValue="value" optionLabel="label" class="w-100" placeholder="Default"/>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CUSTOM CLASS</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedRow.settings.class" class="w-100" />
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
import InputNumber from "primevue/inputnumber";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import ColumnCounts from "./ColumnCounts";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";


import {rowSettingOptions} from "./design-elements-data.js";
const props = defineProps({
    row:Object,
    hideSettings:Function
});

const selectedRow = ref(props.row);

const setRowBgImage = (media) => {
    selectedRow.value.settings.background.image = media.original_url;
}

</script>