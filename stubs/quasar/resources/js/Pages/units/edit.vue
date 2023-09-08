<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 460px">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.unit.title_edit") }} :
                    {{ table.row.name || single.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            filled
                            clearable
                            v-model="single.entry.name"
                            :label="$t('input.unit.name')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error="single.errors.name ? true : false"
                            :error-message="single.errors.name"
                        />

                        <q-input
                            filled
                            clearable
                            v-model="single.entry.num"
                            :label="$t('input.unit.num')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="number"
                            :error="single.errors.num ? true : false"
                            :error-message="single.errors.num"
                        />
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.update')"
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
import { useUnitsIndex } from "@/stores/units/index";
import { useSettings } from "@/stores/settings";
import { useForms } from "@/Composables/Forms";
import { watch } from "vue";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useUnitsIndex();

watch(table, (e) => {
    if (e.editRow) {
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
