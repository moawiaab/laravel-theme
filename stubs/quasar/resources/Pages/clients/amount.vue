<template>
    <q-dialog
        v-model="amount.dialog"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card
            :style="`min-width: ${
                $q.screen.width.sm || $q.screen.width.xz ? '100vw' : '50vw'
            }`"
        >
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.client.title_amount") }}:
                    {{ amount.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <q-splitter
                        v-model="settings.splitterModel"
                        style="height: 100%"
                    >
                        <template v-slot:before>
                            <div class="q-pa-sm">
                                <q-input
                                    filled
                                    borderless
                                    clearable
                                    v-model="amount.data.amount"
                                    :label="$t('input.all.amount')"
                                    :rules="[
                                        (val) => !!val || $t('input.client.v1'),
                                        (val) =>
                                            (amount.entry.type == 2
                                                ? val * 2
                                                : amount.data.status == 1
                                                ? amount.entry.type == 1 &&
                                                  parseInt(
                                                      amount.entry.amount < 0
                                                          ? amount.entry
                                                                .amount * -1
                                                          : amount.entry.amount
                                                  ) +
                                                      parseInt(val) <=
                                                      amount.entry.roof
                                                : val > 0) ||
                                            $t('input.client.v2'),
                                    ]"
                                    type="number"
                                    :error="amount.errors.amount ? true : false"
                                    :error-message="
                                        amount.errors.amount
                                            ? amount.errors.amount[0]
                                            : ''
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
                                    :rules="[
                                        (val) =>
                                            val != null || $t('v.selected'),
                                    ]"
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
                                        :rules="[
                                            (val) => !!val || $t('v.required'),
                                        ]"
                                        :error="
                                            amount.errors.name ? true : false
                                        "
                                        :error-message="amount.errors.name"
                                    />
                                    <q-input
                                        filled
                                        clearable
                                        type="number"
                                        lazy-rules
                                        v-model="amount.data.num"
                                        :label="$t('input.client.check_num')"
                                        :rules="[
                                            (val) => !!val || $t('v.required')
                                        ]"
                                        :error="
                                            amount.errors.num ? true : false
                                        "
                                        :error-message="amount.errors.num"
                                    />
                                </div>
                            </div>
                        </template>

                        <template v-slot:separator>
                            <q-avatar
                                color="primary"
                                text-color="white"
                                size="20px"
                                icon="drag_indicator"
                            />
                        </template>

                        <template v-slot:after>
                            <div class="q-pa-sm">
                                <q-item-label caption class="q-my-md">
                                    {{ $t("g.type") }}
                                </q-item-label>
                                <!-- <q-option-group
                  v-model="amount.data.status"
                  :options="amount.status"
                  color="red"
                /> -->
                                <q-item
                                    v-for="item in amount.status"
                                    :key="item.value"
                                >
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
                                                    amount.entry.amount < 0
                                                        ? amount.entry.amount *
                                                              -1
                                                        : amount.entry.amount
                                                ) +
                                                    parseInt(
                                                        amount.data.amount
                                                    ) >
                                                    amount.entry.roof) ||
                                            (item.value == 1 &&
                                                amount.entry.type == 0)
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
                                        :rules="[
                                            (val) => !!val || $t('v.required'),
                                        ]"
                                        :error="
                                            amount.errors.bank ? true : false
                                        "
                                        :error-message="amount.errors.bank"
                                    />
                                    <q-input
                                        filled
                                        clearable
                                        type="date"
                                        lazy-rules
                                        v-model="amount.data.date"
                                        :label="$t('input.client.check_date')"
                                        :rules="[
                                            (val) => !!val || $t('v.required')
                                        ]"
                                        :error="
                                            amount.errors.date ? true : false
                                        "
                                        :error-message="amount.errors.date"
                                    />
                                </div>
                            </div>
                        </template>
                    </q-splitter>

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
                </q-card-section>

                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
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
