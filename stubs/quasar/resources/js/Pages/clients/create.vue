<template>
    <m-dialog v-model="dialog" :title="$t('input.client.title_new')">
        <form-data @submitted="onSubmit" @reset="onReset">
            <template #form1>
                <m-input
                    v-model="single.entry.name"
                    :label="$t('input.client.name')"
                    :rules="[(val) => !!val || $t('v.required')]"
                    :error="single.errors.name"
                    icon="person"
                />

                <m-input
                    v-model="single.entry.email"
                    :label="$t('g.email')"
                    type="email"
                    :error="single.errors.email"
                    icon="email"
                />
            </template>

            <template #form2>
                <q-input
                    filled
                    clearable
                    lazy-rules
                    v-model="single.entry.phone"
                    :label="$t('g.phone_number')"
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="phone"
                    :error="single.errors.phone ? true : false"
                    :error-message="single.errors.phone"
                >
                    <template #append>
                        <q-icon name="phone" />
                    </template>
                </q-input>
                <q-select
                    filled
                    clearable
                    emit-value
                    map-options
                    v-model="single.entry.type"
                    :options="single.lists.type"
                    :label="$t('input.client.type')"
                    :rules="[(val) => val != null || $t('v.selected')]"
                    option-label="label"
                    option-value="value"
                />
            </template>

            <template #footer>
                <q-input
                    filled
                    clearable
                    lazy-rules
                    v-model="single.entry.address"
                    :label="$t('g.address')"
                    class="q-pa-sm"
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
import { useTables } from "@/stores/tables/index";
import { useClientsIndex } from "@/stores/clients/index";
import { useSettings } from "@/stores/settings";
import { ref, watch } from "vue";
import { useForms } from "@/Composables/Forms";
const settings = useSettings();

const dialog = ref(false);
const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useClientsIndex();
watch(table, (e) => {
    if (e.newRow) {
        dialog.value = true;
        single.$reset();
        single.fetchCreateData();
    }
});

watch(single, (e) => {
    if (e.newRow) {
        dialog.value = true;
        single.$reset();
        table.outPage = true;
        single.fetchCreateData();
    }
});

watch(dialog, (e) => {
    if (e === false) {
        table.newRow = false;
    }
});

const onSubmit = () => {
    single.storeData().then(() => (dialog.value = false));
};

const onReset = () => {
    single.entry = {};
};
</script>

<style></style>
