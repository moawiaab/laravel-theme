<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.budget_name.title_edit") }}:
                    {{ table.row.name || budget.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
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
                            :rules="[(val) => val != null || $t('v.selected')]"
                            option-label="name"
                            option-value="id"
                        >
                            <template #append>
                                <q-icon name="mdi-source-branch" />
                            </template>
                        </q-select>
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
