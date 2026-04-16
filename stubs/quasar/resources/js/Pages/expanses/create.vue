<template>
    <m-dialog
        v-model="table.newRow"
        :title="$t('input.expanse.title_new')"
        :mh="100"
        :w="40"
    >
        <one-form
            @submitted="onSubmit"
            @reset="onReset"
            class="q-gutter-md"
            :loading="single.loading"
            btn-label="g.save"
        >
            <f-select
                v-model="single.entry.budget_id"
                :options="single.lists.budgets"
                :label="$t('input.expanse.name')"
                :rules="[(val) => val != null || $t('v.selected')]"
                @update:model-value="setAmount"
                icon="mdi-source-branch"
                :error="single.errors.budget_id"
            />
            <m-input
                v-model="single.entry.amount"
                :label="$t('input.all.amount')"
                :rules="[
                    (val) => !!val || $t('input.expanse.r1'),
                    (val) =>
                        (single.lists.roof == 1
                            ? parseInt(single.amount - val)
                            : parseInt(val) + parseInt(single.expense)) <=
                            parseInt(single.amount) || $t('input.expanse.r2'),
                ]"
                type="number"
                :error="single.errors.amount"
                icon="payments"
            />

            <m-input
                v-model="single.entry.details"
                :label="$t('input.expanse.details')"
                :rules="[(val) => !!val || $t('v.required')]"
                type="textarea"
                :error="single.errors.details"
                icon="info"
            />
        </one-form>
    </m-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useExpansesIndex } from "@/stores/expanses/index";
import { useSettings } from "@/stores/settings";
// import { Expanse } from "@/types";
import { useForms } from "@/Composables/rules";
import { watch } from "vue";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useExpansesIndex();
watch(table, (e) => {
    if (e.newRow) {
        single.$reset();
        single.fetchCreateData();
    }
});

const onSubmit = () => {
    single.storeData();
};

const onReset = () => {
    single.entry = {};
};

const setAmount = (i) => {
    const amount = single.lists.budgets.find((e) => e.id == i);
    single.amount = amount.amount;
    single.expense = amount.expense;
};
</script>

<style></style>
