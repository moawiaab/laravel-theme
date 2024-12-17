<template>
    <q-dialog
        v-model="dialog"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{$t('input.client.title_new')}}</div>
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

                                <q-input
                                    filled
                                    clearable
                                    lazy-rules
                                    v-model="single.entry.email"
                                    :label="$t('g.email')"
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
                        :label="$t('g.reset') "
                        type="reset"
                        color="warning"
                        flat
                        class="q-ml-sm"
                    />
                    <q-btn
                        flat
                        :label="$t('g.close') "
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
        table.newRow = false
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
