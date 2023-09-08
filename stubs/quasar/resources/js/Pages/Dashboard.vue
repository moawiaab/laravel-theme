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
        <div class="row" v-if="data">
            <div class="col-6" v-if="data.line">
                <charts-line :chartData="data.line" />
            </div>
            <div class="col-6" v-if="data.line">
                <charts-bubble :chartData="data.line" />
            </div>
        </div>

        <div class="" v-if="data">
            <charts-bar :chartData="data.barChart" v-if="data.barChart" />
        </div>

        <print-page
            :display="false"
            title="ok"
            :rows="rows"
            :columns="columns"
            bodyStyle="padding:50px; "
        >
            <template #head> </template>
            <!-- <template #body>
                <tr v-for="(i, id) in rows" :key="id" style="width: 100%">
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.id }}
                    </td>
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.title }}
                    </td>
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.age }}
                    </td>
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.num }}
                    </td>
                    <td
                        style="
                            border: 1px solid #ccc;
                            border-top: none;
                            text-align: center;
                        "
                    >
                        {{ i.amount }}
                    </td>
                </tr>
            </template> -->
        </print-page>
        <button
            id="myBtnPrint"
            type="button"
            style="display: none"
            @click="$htmlToPaper('printMe', null, () => {})"
        >
            print
        </button>
        <q-btn @click="print">print pdf</q-btn>
    </q-page>
</template>

<script setup>
import ShowCard from "@/Components/Widgets/ShowCard.vue";
import ChartsBar from "@/Components/Charts/Bar.vue";
import ChartsBubble from "@/Components/Charts/Bubble.vue";
import ChartsLine from "@/Components/Charts/Line.vue";
import PrintPage from "@/Components/print/page.vue";
import axios from "axios";
import { onMounted, ref } from "vue";

import { useI18n } from "vue-i18n";

const data = ref();
onMounted(async () => {
    await axios.get("/dashboard").then((res) => {
        data.value = res.data;
    });
});

const columns = [
    { name: "id", label: "الكود", field: "id" },
    { name: "title", label: "الاسم", field: "title" },
    { name: "age", label: "العمر", field: "age" },
    { name: "num", label: "العمر", field: "num" },
    { name: "amount", label: "العمر", field: "amount" },
];
const rows = ref([
    { id: 1, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 2, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 3, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 4, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 5, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 6, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 7, title: "test title", age: 15, num: 65, amount: 5648 },
    { id: 8, title: "test title", age: 15, num: 65, amount: 5648 },
]);

const print = () => {
    document.getElementById("myBtnPrint")?.click();
};
</script>
<style scoped>
.q-img__content > div {
    padding: 2px 6px !important;
}
</style>
