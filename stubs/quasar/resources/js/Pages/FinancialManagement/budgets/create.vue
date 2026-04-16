<template>
    <m-dialog
        v-model="table.newRow"
        :title="$t('input.budget.title_new')"
        :w="40"
    >
        <one-form @submitted="onSubmit" @reset="onReset"   :loading="budget.loading"
               >
            <f-select
                v-model="budget.entry.budget_id"
                :options="budget.lists.budgets"
                :label="$t('input.budget.name')"
                :rules="[(val) => val != null || $t('v.selected')]"
                icon="mdi-source-branch"
            />
            <m-input
                v-model="budget.entry.amount"
                :label="$t('input.budget.amount')"
                :rules="[(val) => !!val || $t('v.required')]"
                type="number"
                :error="budget.errors.amount"
                icon="payments"
            />
        </one-form>
    </m-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useBudgetsIndex } from "@/stores/budgets/index";
import { useSettings } from "@/stores/settings";
import { watch } from "vue";
import { useForms } from "@/Composables/Forms";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const budget = useBudgetsIndex();
watch(table, (e) => {
    if (e.newRow) {
        budget.$reset();
        budget.fetchCreateData();
    }
});

const onSubmit = () => {
    budget.storeData();
};

const onReset = () => {
    budget.entry = {};
};
</script>

<style></style>
