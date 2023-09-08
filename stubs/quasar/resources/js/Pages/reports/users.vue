<script lang="ts" setup>
import axios from "axios";
import { Orders, Amount, BackOrders, Expanses } from "@/types/columns";
import { ref, watch } from "vue";
const data = ref();
const date = ref();
const user = ref();
const getData = async () => {
    const { data: myData } = await axios.get("/reports", {
        params: {
            user_id: user.value,
            date: date.value,
        },
    });
    data.value = myData;
};
getData();

watch(date, () => {
    getData();
});
</script>

<template>
    <q-page class="q-pa-sm" v-if="data">
        <div class="row q-px-xs">
            <div class="col q-px-sm">
                <input-text
                    type="date"
                    :label="$t('input.report.date')"
                    v-model="date"
                >
                    <template #append> <q-icon name="mdi-calendar" /> </template
                ></input-text>
            </div>
            <div class="col q-px-sm">
                <input-select
                    :label="$t('input.report.user')"
                    :options="data.meta.users"
                    option-label="name"
                    option-value="id"
                    v-model="user"
                    @update:model-value="getData"
                >
                    <template #append> <q-icon name="search" /> </template>
                </input-select>
            </div>
        </div>
        <div class="row q-pa-sm">
            <widgets-show-card
                icon="mdi-cart-arrow-up"
                :text="data.data.all_amount"
                title="input.report.w1"
                color="green"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer-in"
                :text="data.data.cl_add"
                title="input.report.w2"
                color="blue"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer-in"
                :text="data.data.supp_add"
                title="input.report.w3"
                color="pink"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>
        <div class="row q-pa-sm" v-if="data.data">
            <widgets-show-card
                icon="mdi-bank-transfer-out"
                :text="data.data.cl_teg"
                title="input.report.w4"
                color="red"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer-out"
                :text="data.data.supp_teg"
                title="input.report.w5"
                color="grey"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-finance"
                :text="data.data.amount"
                title="input.report.w6"
                color="purple"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>
        <div class="q-ma-sm">
            <q-table
                :rows="data.meta.orders"
                :columns="Orders"
                :title="$t('input.report.order1')"
                title-class="text-blue"
            >
                <template #header="props">
                    <q-tr :props="props">
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            {{ $t(col.label) }}
                        </q-th>
                    </q-tr>
                </template>
            </q-table>
            <q-table
                :rows="data.meta.clientAmount"
                :columns="Amount"
                title-class="text-pink"
                :title="$t('input.report.a1')"
            >
                <template #header="props">
                    <q-tr :props="props">
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            {{ $t(col.label) }}
                        </q-th>
                    </q-tr>
                </template>
            </q-table>
            <q-table
                :rows="data.meta.suppAmount"
                :columns="Amount"
                title-class="text-green"
                 :title="$t('input.report.a2')"
            >
                <template #header="props">
                    <q-tr :props="props">
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            {{ $t(col.label) }}
                        </q-th>
                    </q-tr>
                </template>
            </q-table>

            <q-table
                :rows="data.meta.backs"
                :columns="BackOrders"
                title-class="text-red"
                :title="$t('input.report.a3')"
            >
                <template #header="props">
                    <q-tr :props="props">
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            {{ $t(col.label) }}
                        </q-th>
                    </q-tr>
                </template>
            </q-table>

            <q-table
                :rows="data.meta.expanses"
                :columns="Expanses"
                title-class="info"
                :title="$t('item.expanse')"
            >
                <template #header="props">
                    <q-tr :props="props">
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                        >
                            {{ $t(col.label) }}
                        </q-th>
                    </q-tr>
                </template>
            </q-table>
        </div>
    </q-page>
</template>

<style scoped></style>
