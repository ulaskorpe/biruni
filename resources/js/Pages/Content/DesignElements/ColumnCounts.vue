<template>
    
    <Divider />

    <div class="row align-items-center">
        <label class="col-md-3 fw-bold text-uppercase">COLUMN COUNT</label>
        <div class="col-md-9">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">SM</span>
                        <Dropdown v-model="columnCounts.sm" :options="columCountData.sm" class="w-100" />
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">MD</span>
                        <Dropdown v-model="columnCounts.md" :options="columCountData.md" class="w-100" />
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">LG</span>
                        <Dropdown v-model="columnCounts.lg" :options="columCountData.lg" class="w-100" />
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="p-inputgroup flex-1">
                        <span class="p-inputgroup-addon">XL</span>
                        <Dropdown v-model="columnCounts.xl" :options="columCountData.xl" class="w-100" />
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
    columnCounts:Object,
});

const columnCounts = ref(props.columnCounts);
let counts = [1,2,3,4,5,6,7,8,9,10,11,12,"auto"];
let columCountData = {
    sm:counts,
    md:counts,
    lg:counts,
    xl:counts
}

</script>