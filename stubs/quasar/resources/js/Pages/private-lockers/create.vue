<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{ $t("input.locker.title_new") }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
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
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
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
import { usePrivateLockersIndex } from "@/stores/private-lockers/index";
import { useSettings } from "@/stores/settings";
import { useForms } from "../../Composables/rules";
import { watch, ref } from "vue";
const settings = useSettings();

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
            v.name.includes(needle)
        );
    });
};
</script>

<style></style>
