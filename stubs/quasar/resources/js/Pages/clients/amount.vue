<template>
    <m-dialog
        v-model="amount.dialog"
        :title="`${$t('input.client.title_amount')} :  ${amount.entry.name}`"
        :w="50"
    >
        <form-data @submitted="onSubmit" @reset="onReset">
            <template #form1>
                <q-input
                    filled
                    borderless
                    clearable
                    v-model="amount.data.amount"
                    :label="$t('input.all.amount')"
                    :rules="[(val) => !!val || $t('input.client.v1')]"
                    type="number"
                    :error="amount.errors.amount ? true : false"
                    :error-message="
                        amount.errors.amount ? amount.errors.amount[0] : ''
                    "
                >
                    <template #append>
                        <q-icon name="payments" />
                    </template>
                </q-input>
                <q-select
                    map-options
                    emit-value
                    filled
                    clearable
                    v-model="amount.data.type"
                    :options="amount.type"
                    :label="$t('input.all.type')"
                    :rules="[(val) => val != null || $t('v.selected')]"
                    :option-label="(opt) => $t(opt.label)"
                    option-value="value"
                    :error="amount.errors.type ? true : false"
                    :error-message="amount.errors.type"
                />

                <div class="" v-if="amount.data.type === 5">
                    <q-input
                        filled
                        clearable
                        lazy-rules
                        v-model="amount.data.name"
                        :label="$t('input.client.check_name')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="amount.errors.name ? true : false"
                        :error-message="amount.errors.name"
                    />
                    <q-input
                        filled
                        clearable
                        type="number"
                        lazy-rules
                        v-model="amount.data.num"
                        :label="$t('input.client.check_num')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="amount.errors.num ? true : false"
                        :error-message="amount.errors.num"
                    />
                </div>
            </template>
            <template #form2>
                <q-item-label caption class="q-my-md">
                    {{ $t("g.type") }}
                </q-item-label>
                <q-item v-for="item in amount.status" :key="item.value">
                    <q-radio
                        v-model="amount.data.status"
                        checked-icon="task_alt"
                        unchecked-icon="panorama_fish_eye"
                        :val="item.value"
                        :label="$t(item.label)"
                        :disable="
                            (amount.entry.type == 1 &&
                                item.value == 1 &&
                                parseInt(
                                    amount.entry.amount - amount.data.amount,
                                ) +
                                    parseInt(amount.entry.roof) <
                                    0) ||
                            (item.value == 1 &&
                                amount.entry.type == 0 &&
                                parseInt(
                                    amount.entry.amount - amount.data.amount,
                                ) < 0)
                                ? true
                                : false
                        "
                    />
                </q-item>

                <div class="" v-if="amount.data.type === 5">
                    <q-input
                        filled
                        clearable
                        lazy-rules
                        v-model="amount.data.bank"
                        :label="$t('input.client.check_bank')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="amount.errors.bank ? true : false"
                        :error-message="amount.errors.bank"
                    />
                    <q-input
                        filled
                        clearable
                        type="date"
                        lazy-rules
                        v-model="amount.data.date"
                        :label="$t('input.client.check_date')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="amount.errors.date ? true : false"
                        :error-message="amount.errors.date"
                    />
                </div>
            </template>

            <template #footer>
                <q-input
                    filled
                    clearable
                    class="q-pa-sm"
                    v-model="amount.data.details"
                    :label="$t('g.details')"
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="textarea"
                    :error="amount.errors.details ? true : false"
                    :error-message="amount.errors.details"
                >
                    <template #append>
                        <q-icon name="info" />
                    </template>
                </q-input>
            </template>
        </form-data>
    </m-dialog>
</template>

<script setup>
import { useClientAmounts } from "@/stores/clients/amount";
import { useSettings } from "@/stores/settings";
import { watch } from "vue";
import { useForms } from "@/Composables/Forms";

const settings = useSettings();
const amount = useClientAmounts();
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
    amount.data = {
        amount: null,
        details: null,
        status: 0,
        type: 1,
    };
};
</script>

<style></style>
