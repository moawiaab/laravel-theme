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
                    {{$t('input.user.title_edit')}} :
                    {{ table.row.name || user.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
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
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.update')"
                        type="submit"
                        color="primary"
                        :loading="user.loading"
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
