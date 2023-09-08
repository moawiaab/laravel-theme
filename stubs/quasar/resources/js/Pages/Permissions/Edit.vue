<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="width: 500px; max-width: 80vw">
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.permission.title_edit") }} :
                    {{ table.row.details || permission.entry.details }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="permission.entry.details"
                        :label="$t('input.permission.name')"
                        lazy-rules
                        :rules="[(val) => !!val || $t('v.required')]"
                    />
                    <q-input
                        clearable
                        filled
                        v-model="permission.entry.title"
                        :label="$t('input.permission.url')"
                        lazy-rules
                        :rules="[(val) => !!val || $t('v.required')]"
                    />
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.update')"
                        type="submit"
                        color="primary"
                        :loading="permission.loading"
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

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { usePermissionsIndex } from "../../stores/permissions/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const permission = usePermissionsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                permission.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            permission.updateData(table.row.id);
        };

        const onReset = () => {
            permission.entry = {};
        };
        return { table, rules, permission, onSubmit, onReset };
    },
};
</script>

<style></style>
