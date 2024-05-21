<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card
            :style="`min-width: ${
                $q.screen.width.sm || $q.screen.width.xz ? '100vw' : '50vw'
            }`"
        >
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                   {{$t('input.client.title_edit')}} :
                    {{ table.row.name || single.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
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
                    <q-splitter
                        v-model="settings.splitterModel"
                        style="height: 100%"
                    >
                        <template v-slot:before>
                            <div class="q-pa-sm">
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
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    type="email"
                                    :error="single.errors.email ? true : false"
                                    :error-message="single.errors.email"
                                >
                                    <template #append>
                                        <q-icon name="email" />
                                    </template>
                                </q-input>
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
                                    :rules="[(val) => (val != null) || $t('v.selected')]"
                                    option-label="label"
                                    option-value="value"
                                />
                            </div>
                        </template>
                    </q-splitter>
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
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
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
