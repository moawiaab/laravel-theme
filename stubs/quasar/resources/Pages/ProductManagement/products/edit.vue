<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.product.title_edit") }}:
                    {{ table.row.name || single.entry.name }}
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
                                    clearable
                                    v-model="single.entry.name"
                                    :label="$t('input.product.name')"
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error="single.errors.name ? true : false"
                                    :error-message="single.errors.name"
                                />

                                <q-select
                                    emit-value
                                    filled
                                    map-options
                                    v-model="single.entry.category_id"
                                    :options="single.lists.categories"
                                    :label="$t('input.category.name')"
                                    :rules="[
                                        (val) =>
                                            val != null || $t('v.selected'),
                                    ]"
                                    option-label="name"
                                    option-value="id"
                                />
                                <q-select
                                    emit-value
                                    filled
                                    map-options
                                    v-model="single.entry.unit_id"
                                    :options="single.lists.units"
                                    :label="$t('input.unit.name')"
                                    :rules="[
                                        (val) =>
                                            val != null || $t('v.selected'),
                                    ]"
                                    option-label="name"
                                    option-value="id"
                                />
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
                                <q-input
                                    filled
                                    clearable
                                    v-model="single.entry.amount"
                                    :label="$t('input.product.amount')"
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error="single.errors.amount ? true : false"
                                    :error-message="single.errors.amount"
                                    type="number"
                                    @keyup="single.setAmount"
                                />

                                <q-input
                                    filled
                                    clearable
                                    v-model="single.entry.gain"
                                    :label="$t('input.product.gain')"
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error="single.errors.gain ? true : false"
                                    :error-message="single.errors.gain"
                                    type="number"
                                    @keyup="single.setAmount"
                                />

                                <q-input
                                    filled
                                    clearable
                                    v-model="single.entry.price"
                                    :label="$t('input.product.price')"
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error="single.errors.price ? true : false"
                                    :error-message="single.errors.price"
                                    type="number"
                                />
                            </div>
                        </template>
                    </q-splitter>
                    <q-input
                        filled
                        clearable
                        class="q-px-sm"
                        v-model="single.entry.details"
                        :label="$t('g.details')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="single.errors.details ? true : false"
                        :error-message="single.errors.details"
                        type="textarea"
                    />

                    <q-input
                        filled
                        clearable
                        v-model="single.entry.barcode"
                        :label="$t('input.product.barcode')"
                    />
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
import { useProductsIndex } from "@/stores/products/index";
import { useSettings } from "@/stores/settings";
import { useForms } from "@/Composables/Forms";
import { watch } from "vue";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useProductsIndex();
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
