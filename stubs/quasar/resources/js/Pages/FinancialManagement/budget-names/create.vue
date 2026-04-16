<template>
    <m-dialog
        v-model="table.newRow"
        :title="$t('input.budget.title_new')"
    >
            <one-form @submitted="onSubmit" @reset="onReset" :loading="budget.loading">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            filled
                            clearable
                            v-model="budget.entry.name"
                            :label="$t('input.budget_name.name')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error="budget.errors.name ? true : false"
                            :error-message="budget.errors.name"
                        >
                            <template #append>
                                <q-icon name="edit_note" />
                            </template>
                        </q-input>

                        <q-input
                            filled
                            clearable
                            v-model="budget.entry.details"
                            :label="$t('g.details')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="textarea"
                            :error="budget.errors.details ? true : false"
                            :error-message="budget.errors.details"
                        >
                            <template #append>
                                <q-icon name="info" />
                            </template>
                        </q-input>

                        <q-select
                            filled
                            clearable
                            emit-value
                            map-options
                            v-model="budget.entry.type"
                            :options="budget.lists.type"
                            :label="$t('input.budget_name.status')"
                            :rules="[(val) => (val != null) || $t('v.selected')]"
                            option-label="name"
                            option-value="id"
                        >
                            <template #append>
                                <q-icon name="mdi-source-branch" />
                            </template>
                        </q-select>
                    </div>
                </q-card-section>

            </one-form>
    </m-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useBudgetNameIndex } from "@/stores/budget-names/index";
import { useSettings } from "@/stores/settings";
import { watch } from "vue";
import { useForms } from "@/Composables/Forms";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const budget = useBudgetNameIndex();
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
