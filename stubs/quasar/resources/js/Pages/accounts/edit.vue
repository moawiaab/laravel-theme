<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.account.title_edit") }} :
                    {{ table.row.name || account.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            filled
                            clearable
                            v-model="account.entry.name"
                            :label="$t('input.account.name')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error="account.errors.name ? true : false"
                            :error-message="account.errors.name"
                            lazy-rules
                        >
                            <template #append>
                                <q-icon name="mdi-source-branch" />
                            </template>
                        </q-input>

                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="account.entry.phone"
                            :label="$t('g.two_factor.phone_number')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="phone"
                            :error="account.errors.phone ? true : false"
                            :error-message="account.errors.phone"
                        >
                            <template #append>
                                <q-icon name="phone" />
                            </template>
                        </q-input>

                        <q-input
                            filled
                            clearable
                            lazy-rules
                            v-model="account.entry.details"
                            :label="$t('input.account.details')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="textarea"
                            :error="account.errors.details ? true : false"
                            :error-message="account.errors.details"
                        >
                            <template #append>
                                <q-icon name="info" />
                            </template>
                        </q-input>
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.update')"
                        type="submit"
                        color="primary"
                        :loading="account.loading"
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
import { useAccountIndex } from "@/stores/accounts/index";
import { useSettings } from "@/stores/settings";
import { useForms } from "@/Composables/Forms";
import { watch } from "vue";

const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const account = useAccountIndex();

watch(table, (e) => {
    if (e.editRow) {
        account.fetchEditData(table.row.id);
    }
});

const onSubmit = () => {
    account.updateData(table.row.id);
};

const onReset = () => {
    account.entry = {};
};
</script>

<style></style>
