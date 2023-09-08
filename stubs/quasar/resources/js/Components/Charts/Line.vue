<template>
    <Line :data="chartData" :options="options"  />
</template>

<script lang="ts" setup>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { Line } from "vue-chartjs";

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);
const {
    chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
    },
} = defineProps({ chartOptions: Object, chartData: Object });
</script>
