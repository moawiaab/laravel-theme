<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card
            style="width: 800px; max-width: 80vw"
        >
            <q-card-section>
                <div class="text-h6">
                    {{$t('input.role.title_edit')}} :
                    {{ table.row.title || role.entry.title }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="role.entry.name"
                        :label="$t('input.role.name')"
                        lazy-rules
                        :rules="[(val) => !!val || $t('v.required')]"
                    />

                    <q-select
                        use-chips
                        multiple
                        clearable
                        filled
                        v-model="role.entry.permissions"
                        :options="role.lists.permissions"
                        :label="$t('item.role')"
                        option-value="value"
                        option-label="label"
                        :rules="[(val) => (val != null) || $t('v.selected')]"
                        emit-value
                        map-options
                    />
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                      :label="$t('g.update')"
                        type="submit"
                        color="primary"
                        :loading="role.loading"
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
import { useRolesIndex } from "../../stores/roles/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const role = useRolesIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                role.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            role.updateData(table.row.id);
        };

        const onReset = () => {
            role.entry = {};
        };
        return { table, rules, role, onSubmit, onReset };
    },
};
</script>

<style></style>
