<template>
    <PolarArea :data="chartData" :options="chartOptions" />
</template>

<script lang="ts" setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend, RadialLinearScale } from "chart.js";
import { PolarArea } from "vue-chartjs";
ChartJS.register(RadialLinearScale, ArcElement, Tooltip, Legend)
const {
    chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
    },
} = defineProps({ chartOptions: Object, chartData: Object });
</script>
