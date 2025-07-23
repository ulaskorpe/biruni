<template>
    
    <Divider />

    <div class="row align-items-center">
        <label class="col-md-3 fw-bold text-uppercase">ORDER BY</label>
        <div class="col-md-9">
            <Dropdown v-model="orderBy.value" :options="orderByData" optionLabel="label" optionValue="value" class="w-100" />
        </div>
    </div>


</template>

<script setup>

import {ref} from "vue";
import Divider from "primevue/divider";
import Dropdown from "primevue/dropdown";

const props = defineProps({
    orderBy:Object,
});

const orderBy = ref(props.orderBy);
let orderByData = [
    {
        label:"Default (ID DESC)",
        value:"id DESC"
    },
    {
        label:"Default (ID ASC)",
        value:"id ASC"
    },
    {
        label:"Title (ASC)",
        value:"name ASC"
    },
    {
        label:"Title (DESC)",
        value:"name ASC"
    },
    {
        label:"Order Number (ASC)",
        value:"order_column ASC"
    },
    {
        label:"Order Number (DESC)",
        value:"order_column DESC"
    },
    {
        label:"Created Date (ASC)",
        value:"created_at ASC"
    },
    {
        label:"Created Date (DESC)",
        value:"created_at DESC"
    },
    {
        label:"Publish Date (ASC)",
        value:"start_date ASC"
    },
    {
        label:"Publish Date (DESC)",
        value:"start_date DESC"
    },
    {
        label:"Order Count (ASC)",
        value:"order_count ASC"
    },
    {
        label:"Order Count (DESC)",
        value:"order_count DESC"
    },
    {
        label:"Event Date (ASC)",
        value:"event_date ASC"
    },
    {
        label:"Event Date (DESC)",
        value:"event_date DESC"
    },
    {
        label:"Random",
        value:"RAND()"
    }
];

</script>