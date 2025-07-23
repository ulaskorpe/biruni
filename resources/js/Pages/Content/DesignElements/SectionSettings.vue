<template>
                
            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SECTION ID</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedSection.settings.id" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SECTION NAME</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedSection.settings.name" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">DISPLAY</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="hstack gap-5">
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedSection.settings.display.mobile" />
                            <label class="fw-bold ms-2">Mobile</label>
                        </div>
                        <div class="d-flex flex-row">
                            <InputSwitch v-model="selectedSection.settings.display.desktop" />
                            <label class="fw-bold ms-2">Desktop</label>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!selectedSection.settings.containerAsSlides">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CONTAINERS AS TAB</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedSection.settings.containerAsTabs" />
                    </div>
                </div>
            </div>

            <div v-if="!selectedSection.settings.containerAsTabs">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CONTAINERS AS SLIDES</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedSection.settings.containerAsSlides" />
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
                                <Dropdown v-model="selectedSection.settings.padding.top" :options="sectionSettingOptions.padding.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedSection.settings.padding.right" :options="sectionSettingOptions.padding.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedSection.settings.padding.bottom" :options="sectionSettingOptions.padding.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedSection.settings.padding.left" :options="sectionSettingOptions.padding.left" optionValue="value" optionLabel="label" class="w-100" />
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
                                <Dropdown v-model="selectedSection.settings.margin.top" :options="sectionSettingOptions.margin.top" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                                <Dropdown v-model="selectedSection.settings.margin.right" :options="sectionSettingOptions.margin.right" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                                <Dropdown v-model="selectedSection.settings.margin.bottom" :options="sectionSettingOptions.margin.bottom" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="p-inputgroup flex-1">
                                <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                                <Dropdown v-model="selectedSection.settings.margin.left" :options="sectionSettingOptions.margin.left" optionValue="value" optionLabel="label" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND COLOR</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <Dropdown v-model="selectedSection.settings.background.color" :options="sectionSettingOptions.background.color" filter optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="d-flex flex-row flex-wrap align-items-end">
                        <img :src="selectedSection.settings.background.image" v-if="selectedSection.settings.background.image" class="img-thumbnail me-2" width="200"/>
                        <div class="d-flex flex-row align-items-center">
                            <PopupMediaLibrary v-if="!selectedSection.settings.background.image" :on-select="setSectionBgImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                            <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="selectedSection.settings.background.image" @click="selectedSection.settings.background.image = null">
                                <i class="bi bi-x fs-3"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="selectedSection.settings.background.image">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 fw-bold text-uppercase">BACKGROUND PARALLAX</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedSection.settings.background.parallax" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND IMAGE POSITION</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.background.position" :options="sectionSettingOptions.background.position" optionValue="value" optionLabel="label" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND SIZE</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.background.size" :options="sectionSettingOptions.background.size" optionValue="value" optionLabel="label" class="w-100" />
                    </div>
                </div>

            </div>

            <div v-if="(selectedSection.settings.background.image || selectedSection.settings.background.color) && !selectedSection.settings.background.parallax">
                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND RELATIVE SIZE</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.background.relativeSize" :options="sectionSettingOptions.background.relativeSize" optionValue="value" optionLabel="label" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND RELATIVE POSITION</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.background.relativePosition" :options="sectionSettingOptions.background.relativePosition" showClear optionValue="value" optionLabel="label" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND ANIMATED</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <InputSwitch v-model="selectedSection.settings.background.animated" />
                    </div>
                </div>

                <div v-if="selectedSection.settings.background.animated">
                    <Divider />

                    <div class="row align-items-center">
                        <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND ANIMATION</label>
                        <div class="col-md-6 col-lg-8 col-xl-6">
                            <Dropdown v-model="selectedSection.settings.background.animation" filter showClear :options="sectionSettingOptions.background.animation" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>

            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">BACKGROUND LAYER</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <Dropdown v-model="selectedSection.settings.background.layer.color" :options="sectionSettingOptions.background.layer.color" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                        <div class="col-6">
                            <Dropdown v-model="selectedSection.settings.background.layer.opacity" :options="sectionSettingOptions.background.layer.opacity" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 fw-bold text-uppercase">SHAPE TOP</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputSwitch v-model="selectedSection.settings.shapeTop.active" />
                </div>
            </div>

            <Divider />

            <div v-if="selectedSection.settings.shapeTop && selectedSection.settings.shapeTop.active">
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SHAPE TOP TYPE</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.shapeTop.type" :options="['waves-opacity','wave']" class="w-100" />
                    </div>
                </div>
                <Divider />
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SHAPE TOP COLOR</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.shapeTop.color" :options="['white','primary','secondary','light','gray-50']" class="w-100" />
                    </div>
                </div>
                <Divider />
            </div>

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 fw-bold text-uppercase">SHAPE BOTTOM</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputSwitch v-model="selectedSection.settings.shapeBottom.active" />
                </div>
            </div>

            <Divider />

            <div v-if="selectedSection.settings.shapeBottom && selectedSection.settings.shapeBottom.active">
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SHAPE BOTTOM TYPE</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.shapeBottom.type" :options="['waves-opacity','wave']" class="w-100" />
                    </div>
                </div>
                <Divider />
                <div class="row align-items-center">
                    <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">SHAPE BOTTOM COLOR</label>
                    <div class="col-md-6 col-lg-8 col-xl-6">
                        <Dropdown v-model="selectedSection.settings.shapeBottom.color" :options="['white','primary','secondary','light','gray-50']" class="w-100" />
                    </div>
                </div>
                <Divider />
            </div>

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 fw-bold text-uppercase">FADEIN UP</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputSwitch v-model="selectedSection.settings.fadeInUp" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-6 col-lg-4 col-xl-6 form-label text-uppercase">CUSTOM CLASS</label>
                <div class="col-md-6 col-lg-8 col-xl-6">
                    <InputText v-model="selectedSection.settings.class" class="w-100" />
                </div>
            </div>

            <div class="mt-10 rounded p-3 bg-light border d-flex justify-content-end">
                <Button label="Tamam" @click="props.hideSettings" />
            </div>

</template>

<script setup>

import {onBeforeMount, ref} from "vue";

import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import PopupMediaLibrary from "../../MediaLibrary/PopupMediaLibrary";


import {sectionSettingOptions} from "./design-elements-data.js";
const props = defineProps({
    section:Object,
    hideSettings:Function
});

const selectedSection = ref(props.section);

const setSectionBgImage = (media) => {
    selectedSection.value.settings.background.image = media.original_url;
}

onBeforeMount(() => {

    if(!selectedSection.value.settings.shapeTop) {
        selectedSection.value.settings.shapeTop = {
            color:"",
            active:false,
            type:"wave"
        }
    }

    if(!selectedSection.value.settings.shapeBottom) {
        selectedSection.value.settings.shapeBottom = {
            color:"",
            active:false,
            type:"wave"
        }
    }

    if(!selectedSection.value.settings.fadeInUp) {
        selectedSection.value.settings.fadeInUp = false;
    }

});

</script>