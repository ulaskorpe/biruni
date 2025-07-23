<template>
    <Head head-key="title" title="Dashboard" />

    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Dashboard
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">

            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container  container-xxl">
            <div v-for="(ptype,p) in props.chart_data" :key="p">
                <div class="card mb-5 mb-xl-10" v-if="ptype.totals.length > 0">
                    <div class="card-header">
                        <h3 class="card-title">{{ ptype.name }} aylık satış adetleri</h3>
                    </div>
                    <div class="card-body">
                        <ProductTypeMonthly :chart-data="ptype"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
    canvas {
        height:350px !important;
    }
</style>

<script setup>

import ProductTypeMonthly from '../Components/Charts/ProductTypeMonthly';

const props = defineProps({
    chart_data:Object
});

</script>