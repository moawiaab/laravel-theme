<template>
    <Pie :data="chartData" :options="chartOptions" />
</template>

<script lang="ts" setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'
ChartJS.register(ArcElement, Tooltip, Legend);
const {
    chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
    },
} = defineProps({ chartOptions: Object, chartData: Object });
</script>
