<template>
  <div class="">
    <v-row class="mb-2">
      <v-col>
        <show-card
          color="info"
          icon="mdi-account-supervisor-outline"
          title="المستخدمين"
          :text="charts.num.user"
          subTitle="مستخدم"
        />
      </v-col>
      <v-col>
        <show-card
          color="success"
          icon="mdi-car-brake-alert"
          title="المنتجات"
          :text="50"
          subTitle="تجربة"
        />
      </v-col>
      <v-col>
        <show-card
          color="error"
          icon="mdi-account-tie-hat-outline"
          title="الاقسام"
          :text="50"
          subTitle="قسم"
        />
      </v-col>
      <v-col>
        <show-card
          color="primary"
          icon="mdi-cart-check"
          title="الصلاحيات"
          :text="charts.num.role"
          subTitle="صلاحية"
        />
      </v-col>
    </v-row>

    <v-divider />
    <v-row v-if="loading">
      <v-col>
        <BubbleChart />
      </v-col>
      <v-col>
        <BarChart :chartData="charts.bar" :chartOptions="options" />
      </v-col>
    </v-row>

    <v-row v-if="loading">
      <v-col>
        <LineChart />
      </v-col>
      <v-col>
        <PieChart />
      </v-col>
      <v-col>
        <PolarAreaChart />
      </v-col>
    </v-row>

    <v-row v-if="loading">
      <v-col>
        <RadarChart />
      </v-col>
      <v-col>
        <ScatterChart />
      </v-col>
      <v-col>
        <PolarAreaChart />
      </v-col>
    </v-row>
  </div>
</template>

<script lang="ts">
import { onMounted, ref } from "vue";
import BarChart from "../components/Charts/Bar.vue";
import BubbleChart from "../components/Charts/Bubble.vue";
import Doughnut from "../components/Charts/Doughnut.vue";
import LineChart from "../components/Charts/Line.vue";
import PieChart from "../components/Charts/Pie.vue";
import PolarAreaChart from "../components/Charts/PolarArea.vue";
import RadarChart from "../components/Charts/Radar.vue";
import ScatterChart from "../components/Charts/Scatter.vue";

import ShowCard from "../components/widgets/ShowCard.vue";
import axios from "axios";
export default {
  components: {
    BarChart,
    BubbleChart,
    Doughnut,
    LineChart,
    PieChart,
    PolarAreaChart,
    RadarChart,
    ScatterChart,
    ShowCard,
  },
  name: "Dashboard",
  setup(props) {
    const loading = ref(false);
    const charts = ref({
      num: {
        user: 0,
        product: 0,
        category: 0,
        role: 0,
      },
      bar: [],
    });
    onMounted(() => {
      loading.value = false;
      axios.get("dashboard").then((response) => {
        // charts.value = response.data
        // console.log(response.data);
        charts.value = response.data;
        loading.value = true;
        console.log(charts.value);
      });
      loading.value = false;
    });

    const options = {
      responsive: true,
      maintainAspectRatio: true,
    };
    return { charts, loading, options };
  },
};
</script>

<style></style>
