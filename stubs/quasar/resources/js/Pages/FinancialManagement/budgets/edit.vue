<template>
    <m-dialog
        v-model="table.editRow"
        :title="
            $t('input.budget.title_edit') +
            ' : ' +
            (table.row.name || budget.entry.name)
        "
        :w="40"
    >
        <one-form @submitted="onSubmit" @reset="onReset"   :loading="budget.loading"
                btnLabel="g.update">
            <q-select
                disable
                filled
                v-model="budget.entry.name"
                :options="budget.lists.budgets"
                :label="$t('input.budget.name')"
                class="q-pb-md"
            >
                <template #append>
                    <q-icon name="mdi-source-branch" />
                </template>
            </q-select>
            <q-input
                filled
                clearable
                v-model="budget.entry.amount"
                :label="$t('input.budget.amount')"
                :rules="[(val) => !!val || $t('v.required')]"
                type="number"
                :error="budget.errors.amount ? true : false"
                :error-message="budget.errors.amount"
            >
                <template #append>
                    <q-icon name="payments" />
                </template>
            </q-input>
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
    if (e.editRow) {
        budget.fetchEditData(table.row.id);
    }
});

const onSubmit = () => {
    budget.updateData(table.row.id);
};

const onReset = () => {
    budget.entry = {};
};
</script>

<style></style>
