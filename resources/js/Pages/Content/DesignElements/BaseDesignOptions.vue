<template>
    
    <Divider />
    <div class="row align-items-center">
        <label class="col-md-3 fw-bold text-uppercase">POSITION</label>
        <div class="col-md-9">
            <Dropdown v-model="baseDesignOptions.position" showClear :options="['position-relative','position-absolute','position-sticky']" class="w-100" />
        </div>
    </div>

    <Divider />
    <div class="row align-items-center">
        <label class="col-md-3 fw-bold text-uppercase">CLASS</label>
        <div class="col-md-9">
            <InputText class="w-100" v-model="baseDesignOptions.class"/>
        </div>
    </div>

    <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">PADDING</label>
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-up"></i></span>
                            <Dropdown v-model="baseDesignOptions.padding.top" :options="paddings.top" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                            <Dropdown v-model="baseDesignOptions.padding.right" :options="paddings.right" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                            <Dropdown v-model="baseDesignOptions.padding.bottom" :options="paddings.bottom" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                            <Dropdown v-model="baseDesignOptions.padding.left" :options="paddings.left" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">MARGIN</label>
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-up"></i></span>
                            <Dropdown v-model="baseDesignOptions.margin.top" :options="margins.top" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-right"></i></span>
                            <Dropdown v-model="baseDesignOptions.margin.right" :options="margins.right" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-down"></i></span>
                            <Dropdown v-model="baseDesignOptions.margin.bottom" :options="margins.bottom" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="p-inputgroup flex-1">
                            <span class="p-inputgroup-addon"><i class="bi bi-arrow-left"></i></span>
                            <Dropdown v-model="baseDesignOptions.margin.left" :options="margins.left" optionValue="value" optionLabel="label" class="w-100" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Divider />

        <div class="row align-items-center">
            <label class="col-md-3 fw-bold text-uppercase">USE ANIMATION?</label>
            <div class="col-md-9">
                <InputSwitch v-model="animOptions.use" />
            </div>
        </div>

        <div v-if="animOptions.use">

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">ANIMATION</label>
                <div class="col-md-9">
                    <Dropdown v-model="animOptions.class" filter :options="animations" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

            <Divider />

            <div class="row align-items-center">
                <label class="col-md-3 fw-bold text-uppercase">DELAY</label>
                <div class="col-md-9">
                    <Dropdown v-model="animOptions.delay" :options="animationDelays" optionValue="value" optionLabel="label" class="w-100" />
                </div>
            </div>

        </div>

</template>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";

import {margins,paddings,animations,animationDelays} from "./design-elements-data.js";

const props = defineProps({
    baseDesignOptions:Object,
    animOptions:Object
});

const baseDesignOptions = ref(props.baseDesignOptions);
const animOptions = ref(props.animOptions);

</script>