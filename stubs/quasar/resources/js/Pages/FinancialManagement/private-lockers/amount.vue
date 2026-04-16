<template>
    <m-dialog
        v-model="amount.dialog"
        :title="$t('input.public.amount') + ' : ' + (amount.entry.name || '')"
        :w="40"
    >
        <one-form @submitted="onSubmit" @reset="onReset" :loading="amount.loading">
            <q-list separator>
                <item-label
                    :label="`${$t('input.public.name')} :  ${
                        amount.entry.name
                    }`"
                />
                <item-label
                    :label="`${$t('input.all.r_amount')} :  ${
                        amount.entry.amount
                    }`"
                />
                <q-separator />
                <q-input
                    filled
                    clearable
                    v-model="amount.data.amount"
                    :label="$t('input.all.amount')"
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="number"
                >
                    <template #append>
                        <q-icon name="payments" />
                    </template>
                </q-input>
                <q-item>
                    <q-chip square :label="amount.entry.amount" />
                    <q-chip square icon="mdi-arrow-all" />
                    <q-chip square :label="amount.data.amount" />
                    <q-chip square icon="mdi-arrow-all" />
                    <q-chip
                        square
                        :label="amount.entry.amount - amount.data.amount || 0"
                    />
                </q-item>
                <q-input
                    filled
                    clearable
                    v-model="amount.data.details"
                    :label="$t('g.details')"
                >
                    <template #append>
                        <q-icon name="info" />
                    </template>
                </q-input>
            </q-list>
        </one-form>
    </m-dialog>
</template>

<script setup>
import { useAmounts } from "@/stores/private-lockers/amount";
import { useForms } from "../../../Composables/rules";
import { watch } from "vue";
const amount = useAmounts();
const { rules: rulesData } = useForms();
const rules = rulesData;

const onSubmit = () => {
    amount.sendAmount();
};

watch(amount, (e) => {
    if (!e.dialog) {
        e.data.amount = null;
        e.data.details = null;
    }
});
const onReset = () => {
    budget.entry = {};
};
</script>

<style></style>
