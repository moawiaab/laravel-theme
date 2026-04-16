<template>
    <m-dialog
        v-model="table.editRow"
        :title="
            $t('input.user.title_edit') +
            ' : ' +
            (table.row.name || user.entry.name)
        "
    >
        <one-form @submitted="onSubmit" @reset="onReset"   :loading="user.loading"
                btnLabel="g.update">
            <div class="q-pa-sm">
                <q-input
                    clearable
                    filled
                    v-model="user.entry.name"
                    :label="$t('g.user_name')"
                    lazy-rules
                    :rules="[(val) => !!val || $t('v.required')]"
                />
                <q-input
                    clearable
                    filled
                    v-model="user.entry.email"
                    :label="$t('g.login_email')"
                    lazy-rules
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="email"
                />
                <q-input
                    clearable
                    filled
                    v-model="user.entry.phone"
                    :label="$t('g.phone_number')"
                    lazy-rules
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="phone"
                />

                <q-select
                    clearable
                    filled
                    v-model="user.entry.role_id"
                    :options="user.lists.roles"
                    :label="$t('input.user.role')"
                    option-value="id"
                    option-label="title"
                    :rules="[(val) => val != null || $t('v.selected')]"
                    emit-value
                    map-options
                />
            </div>
        </one-form>
    </m-dialog>
</template>

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { useUsersIndex } from "../../stores/users/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const user = useUsersIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                user.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            user.updateData(table.row.id);
        };

        const onReset = () => {
            user.entry = {};
        };
        return { table, rules, user, onSubmit, onReset };
    },
};
</script>

<style></style>
