<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{ $t("input.expanse.title_new") }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="">

                                <q-select
                                    filled
                                    clearable
                                    emit-value
                                    map-options
                                    v-model="single.entry.budget_id"
                                    :options="single.lists.budgets"
                                    :label="$t('input.expanse.name')"
                                    :rules="[(val) => (val != null) || $t('v.selected')]"
                                    option-label="name"
                                    option-value="id"
                                    @update:model-value="setAmount"
                                >
                                    <template #append>
                                        <q-icon name="mdi-source-branch" />
                                    </template>
                                </q-select>
                                <q-input
                                    filled
                                    borderless
                                    clearable
                                    v-model="single.entry.amount"
                                    :label="$t('input.all.amount')"
                                    :rules="[
                                        (val) => !!val || $t('input.expanse.r1'),
                                        (val) =>
                                            (single.lists.roof == 1
                                                ? parseInt(single.amount - val)
                                                : parseInt(val) +
                                                  parseInt(single.expense)) <=
                                                parseInt(single.amount) ||
                                            $t('input.expanse.r2'),
                                    ]"
                                    type="number"
                                    :error="single.errors.amount ? true : false"
                                    :error-message="
                                        single.errors.amount
                                            ? single.errors.amount[0]
                                            : ''
                                    "
                                >
                                    <template #append>
                                        <q-icon name="payments" />
                                    </template>
                                </q-input>


  <q-input
                                    filled
                                    clearable
                                    v-model="single.entry.details"
                                    :label="$t('input.expanse.details')"
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    type="textarea"
                                    :error="single.errors.details"
                                >
                                    <template #append>
                                        <q-icon name="info" />
                                    </template>
                                </q-input>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
                        type="submit"
                        color="primary"
                        :loading="single.loading"
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
