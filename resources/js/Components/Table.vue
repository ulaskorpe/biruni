<template>
    
    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table mb-0 table-row-bordered border gy-5 gs-7">
                    <thead class="bg-light">
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th v-for="(head,h) in rows" :key="h">{{ head.title }}</th>
                            <slot name="customHeads"/>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in data.data" :key="index">
                            <td v-for="(col,c) in rows" :key="c">{{ item[col.value] }}</td>
                            <slot name="customCols"/>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <Pagination :links="data.links" />
        </div>
    </div>
    
</template>
<script setup>

    import Pagination from "./Pagination";

    defineProps({
        rows: Object,
        data:Object,
    });
    
    // BUNA SONRA BAKALIM. TABLOLARI COMPONENT OLARAK YAPABILIRIZ.
</script>