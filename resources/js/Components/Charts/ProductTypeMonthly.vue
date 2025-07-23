<template>

<Chart type="bar" :data="chartDrawData" :options="chartDrawOptions" />
    
</template>

<script setup>

import {ref, onMounted} from "vue";
import Chart from 'primevue/chart';

const props = defineProps({
    chartData: Object
});

const chartDrawData = ref();
const chartDrawOptions = ref();

onMounted(() => {
    chartDrawData.value = setChartData();
    chartDrawOptions.value = setChartOptions();
});

const setChartData = () => {
    return {
        labels: props.chartData.totals.map((x) => x.month),
        datasets: [
            {
                data: props.chartData.totals.map((x) => x.count_total)
            }
        ]
    };
};

const setChartOptions = () => {
    
    return {
        plugins: {
            legend: {
                display:false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
            }
        },
        responsive:true,
        maintainAspectRatio: false,
    };
}

</script>