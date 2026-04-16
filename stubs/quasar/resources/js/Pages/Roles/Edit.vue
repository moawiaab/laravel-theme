<template>
    <m-dialog
        v-model="table.editRow"
        :title="
            $t('input.role.title_edit') +
            ' : ' +
            (table.row.title || role.entry.title)
        "
    >
        <one-form @submitted="onSubmit" @reset="onReset"   :loading="role.loading"
                btnLabel="g.update">
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
                :rules="[(val) => val != null || $t('v.selected')]"
                emit-value
                map-options
            />
        </one-form>
    </m-dialog>
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
