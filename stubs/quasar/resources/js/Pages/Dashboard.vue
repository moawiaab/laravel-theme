<template>
    <q-page padding>
        <!-- style="display: none" -->

        <div class="row" v-if="data">
            <show-card
                icon="mdi-account"
                :text="data.num.user"
                title="w.users"
                color="green"
                subTitle="w.user"
                class="q-mr-xs"
            />
            <show-card
                icon="mdi-format-list-checkbox"
                :text="data.num.product"
                title="w.products"
                color="blue"
                subTitle="w.product"
                class="q-mr-xs"
            />

            <show-card
                icon="mdi-account-supervisor-outline"
                :text="data.num.client"
                title="w.clients"
                color="grey"
                subTitle="w.client"
                class="q-mr-xs"
            />

            <show-card
                icon="mdi-storefront-minus-outline"
                :text="data.num.store"
                title="w.stores"
                color="red"
                subTitle="w.store"
                class="q-mr-xs"
            />
        </div>
        <div class="row"  v-if="data">
            <!-- <div class="col-3"><ChartsBubble/></div> -->
            <!-- <div class="col-3"><ChartsDoughnut/></div> -->
            <div class="col-3"><ChartsPie :chartData="data.pieChart"/></div>
            <div class="col-3"><ChartsPolarArea :chartData="data.pieChart"/></div>
            <!-- <div class="col-3"><ChartsRadar/></div> -->
            <div class="col-6"><ChartsLine  :chartData="data.lineChart"/></div>
        </div>
        <div class="" v-if="data">
            <charts-bar :chartData="data.barChart" v-if="data.barChart" />
        </div>
    </q-page>
</template>

<script setup>
import ShowCard from "@/Components/Widgets/ShowCard.vue";
import ChartsBar from "@/Components/Charts/Bar.vue";
import ChartsBubble from "@/Components/Charts/Bubble.vue";
import ChartsDoughnut from "@/Components/Charts/Doughnut.vue";
import ChartsPie from "@/Components/Charts/Pie.vue";
import ChartsPolarArea from "@/Components/Charts/PolarArea.vue";
import ChartsRadar from "@/Components/Charts/Radar.vue";
import ChartsLine from "@/Components/Charts/Line.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const data = ref();
onMounted(async () => {
    await axios.get("/dashboard").then((res) => {
        data.value = res.data;
    });
});
</script>
<style scoped>
.q-img__content > div {
    padding: 2px 6px !important;
}
</style>
