<template>
    <Bar :data="chartData" :options="chartOptions" class=""/>
</template>

<script setup>
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);
const {
    chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
    },
} = defineProps({ chartOptions: Object, chartData: Object });
</script>
