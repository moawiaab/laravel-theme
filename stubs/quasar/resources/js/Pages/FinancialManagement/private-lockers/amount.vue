<template>
    <q-dialog
        v-model="amount.dialog"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="min-width: 50vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{ $t("input.locker.view") }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
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
                                    :label="
                                        amount.entry.amount -
                                            amount.data.amount || 0
                                    "
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
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.send')"
                        type="submit"
                        color="primary"
                        :loading="amount.loading"
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
