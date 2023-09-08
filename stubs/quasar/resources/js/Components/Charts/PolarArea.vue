<template>
    <PolarArea :data="data" :options="options" />
</template>

<script lang="ts">
import { Chart as ChartJS, ArcElement, Tooltip, Legend, RadialLinearScale } from "chart.js";
import { PolarArea } from "vue-chartjs";
ChartJS.register(RadialLinearScale, ArcElement, Tooltip, Legend)
export default {
    name: "PolarAreaChart",
    components: {
        PolarArea,
    },
    setup() {
        const data = {
            labels: [
                "Eating",
                "Drinking",
                "Sleeping",
                "Designing",
                "Coding",
                "Cycling",
                "Running",
            ],
            datasets: [
                {
                    label: "My First dataset",
                    backgroundColor: "rgba(22,181,819,0.2)",
                    pointBackgroundColor: "rgba(179,200,250)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(25,181,198,1)",
                    data: [65, 59, 90, 81, 56, 55, 40],
                },
                {
                    label: "My Second dataset",
                    backgroundColor: "rgba(255,99,132,0.2)",
                    pointBackgroundColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(255,99,132,1)",
                    data: [28, 48, 40, 19, 96, 27, 100],
                },
            ],
        };
        const options = {
            responsive: true,
            maintainAspectRatio: true,
        };
        return { data, options };
    },
};
</script>
