<template>
    <m-dialog
        v-model="table.newRow"
        :title="$t('input.locker.title_new')"
        :w="40"
    >
        <one-form @submitted="onSubmit" @reset="onReset"   :loading="budget.loading"
                btnLabel="g.save">
            <q-select
                filled
                clearable
                emit-value
                map-options
                use-input
                @filter="filterFn"
                v-model="budget.entry.user_id"
                :options="options"
                :label="$t('input.public.name')"
                :rules="[(val) => val != null || $t('v.selected')]"
                option-label="name"
                option-value="id"
            >
                <template #append>
                    <q-icon name="mdi-account" />
                </template>
            </q-select>
            <q-input
                filled
                clearable
                v-model="budget.entry.amount"
                :label="$t('input.all.r_amount')"
                type="number"
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
import { usePrivateLockersIndex } from "@/stores/private-lockers/index";
import { useForms } from "../../../Composables/rules";
import { watch, ref } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const budget = usePrivateLockersIndex();
const options = ref();
watch(table, (e) => {
    if (e.newRow) {
        budget.$reset();
        budget.fetchCreateData();
        options.value = budget.lists.users;
    }
});

const onSubmit = () => {
    budget.storeData();
};

const onReset = () => {
    budget.entry = {};
};

const filterFn = (val, update) => {
    if (val === "") {
        update(() => {
            options.value = budget.lists.users;

            // here you have access to "ref" which
            // is the Vue reference of the QSelect
        });
        return;
    }

    update(() => {
        const needle = val.toLowerCase();
        options.value = budget.lists.users.filter((v) =>
            v.name.includes(needle),
        );
    });
};
</script>

<style></style>
