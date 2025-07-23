<template>
    
    <Divider />

    <div class="row align-items-center">
        <label class="col-md-3 fw-bold text-uppercase">ROW COUNT</label>
        <div class="col-md-9">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">SM</span>
                        <Dropdown v-model="rowCounts.sm" :options="rowCountData.sm" class="w-100" />
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">MD</span>
                        <Dropdown v-model="rowCounts.md" :options="rowCountData.md" class="w-100" />
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">LG</span>
                        <Dropdown v-model="rowCounts.lg" :options="rowCountData.lg" class="w-100" />
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">XL</span>
                        <Dropdown v-model="rowCounts.xl" :options="rowCountData.xl" class="w-100" />
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Dropdown from "primevue/dropdown";

const props = defineProps({
    rowCounts:Object,
});

const rowCounts = ref(props.rowCounts);
let counts = [1,2,3,4,5,6];
let rowCountData = {
    sm:counts,
    md:counts,
    lg:counts,
    xl:counts
}

</script>