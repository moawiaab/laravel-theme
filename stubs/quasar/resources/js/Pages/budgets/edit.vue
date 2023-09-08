<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                   {{$t('input.budget.title_edit')}} :
                    {{ table.row.name || budget.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
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
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.update')"
                        type="submit"
                        color="primary"
                        :loading="budget.loading"
                    />
                    <q-btn
                        :label="$t('g.reset')"
                        type="reset"
                        color="warning"
                        flat
                        class="q-ml-sm"
                    />
                    <q-btn
                        flat
                        :label="$t('g.close')"
                        v-close-popup
                        color="negative"
                    />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>
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
