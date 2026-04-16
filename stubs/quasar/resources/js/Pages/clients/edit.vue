<template>
    <m-dialog
        v-model="table.editRow"
        :title="
            $t('input.client.title_edit') +
            ' : ' +
            (table.row.name || single.entry.name)
        "
    >
        <form-data @submitted="onSubmit" @reset="onReset">
            <template #title>
                <q-input
                    filled
                    clearable
                    lazy-rules
                    v-model="single.entry.name"
                    :label="$t('input.client.name')"
                    :rules="[(val) => !!val || $t('v.required')]"
                    :error="single.errors.name ? true : false"
                    :error-message="single.errors.name"
                >
                    <template #append>
                        <q-icon name="person" />
                    </template>
                </q-input>
            </template>

            <template #form1>
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
                <q-input
                    filled
                    clearable
                    lazy-rules
                    v-model="single.entry.email"
                    :label="$t('g.email')"
                    type="email"
                >
                    <template #append>
                        <q-icon name="email" />
                    </template>
                </q-input>
            </template>
            <template #form2>
                <q-input
                    filled
                    clearable
                    lazy-rules
                    v-model="single.entry.roof"
                    :label="$t('input.client.roof')"
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="number"
                    :error="single.errors.roof ? true : false"
                    :error-message="single.errors.roof"
                >
                    <template #append>
                        <q-icon name="mdi-home-roof" />
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

const locker = ref(true);
const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useClientsIndex();

watch(table, (e) => {
    if (e.editRow) {
        // single.$reset();
        single.fetchEditData(table.row.id);
    }
});

const onSubmit = () => {
    single.updateData(table.row.id);
};

const onReset = () => {
    single.entry = {};
};
</script>

<style></style>
