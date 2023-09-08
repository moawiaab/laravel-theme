<script lang="ts" setup>
import axios from "axios";
import { Orders, Amount } from "@/types/columns";
import { ref, watch } from "vue";
const data = ref();
const date = ref();
const date2 = ref();
const account = ref();
const getData = async () => {
    const { data: myData } = await axios.get("/reports-show", {
        params: {
            account: account.value,
            startDay: date.value,
            endDay: date2.value,
        },
    });
    data.value = myData;
};
getData();

watch(date, () => {
    getData();
});
watch(date2, () => {
    getData();
});

const sum = (obj: any, data: any) => {
    var sum = 0;
    let ab = obj.forEach((element: any) => {
        sum += element[data];
    });
    return isNaN(sum) ? 0 : sum.toFixed(1);
};
</script>

<template>
    <q-page class="q-pa-sm" v-if="data">
        <div class="row q-px-xs">
            <div class="col q-px-sm">
                <q-input
                    filled
                    clearable
                    type="date"
                    :label="$t('input.report.c1')"
                    v-model="date"
                />
            </div>
            <div class="col q-px-sm">
                <q-input
                    filled
                    clearable
                    type="date"
                    :label="$t('input.report.c2')"
                    v-model="date2"
                />
            </div>
            <div class="col q-px-sm">
                <q-select
                    map-options
                    emit-value
                    filled
                    clearable
                    :label="$t('input.report.c3')"
                    :options="data.meta.accounts"
                    option-label="name"
                    option-value="id"
                    v-model="account"
                    @update:model-value="getData"
                >
                    <template #append> <q-icon name="search" /> </template>
                </q-select>
            </div>
        </div>
        <div class="row q-pa-sm">
            <widgets-show-card
                icon="mdi-cart-arrow-up"
                :text="
                    sum(data.meta.items, 'price') -
                    sum(data.meta.items, 'amount')
                "
                title="input.report.c5"
                color="blue"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer-in"
                :text="data.data.expenses"
                title="input.report.c4"
                color="red"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-finance"
                :text="
                    sum(data.meta.items, 'price') -
                    sum(data.meta.items, 'amount') -
                    data.data.expenses
                "
                title="input.report.c6"
                color="green"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>

        <div class="row q-pa-sm">
            <widgets-show-card
                icon="mdi-cart-arrow-up"
                :text="sum(data.meta.products, 'amount')"
                title="input.report.c7"
                color="green"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer-in"
                :text="sum(data.meta.products, 'price')"
                title="input.report.c8"
                color="blue"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-finance"
                :text="
                    sum(data.meta.products, 'price') -
                    sum(data.meta.products, 'amount')
                "
                title="input.report.c9"
                color="pink"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>
        <div class="row q-pa-sm" v-if="data.data">
            <widgets-show-card
                icon="mdi-account-arrow-down-outline"
                :text="data.data.clinout"
                title="input.report.c10"
                color="red"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-account-arrow-up-outline"
                :text="data.data.clinin"
                title="input.report.c11"
                color="grey"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-account-cash-outline"
                :text="data.data.clin"
                title="input.report.c12"
                color="purple"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>
        <div class="row q-pa-sm" v-if="data.data">
            <widgets-show-card
                icon="mdi-account-arrow-down-outline"
                :text="data.data.suppout"
                title="input.report.c13"
                color="info"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-account-arrow-up-outline"
                :text="data.data.suppin"
                title="input.report.c14"
                color="green"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-account-cash-outline"
                :text="data.data.supp"
                title="input.report.c15"
                color="red"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>
    </q-page>
</template>

<style scoped></style>
