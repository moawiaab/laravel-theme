<template>
    <m-dialog
        v-model="table.newRow"

        :title="$t('input.user.title_new')"
    >
            <form-data @submitted="onSubmit" @reset="onReset" class="q-gutter-md"   :loading="user.loading"
                >

                        <template #form1>
                            <div class="q-pa-sm">
                                <q-input
                                    clearable
                                    filled
                                    v-model="user.entry.name"
                                    :label="$t('g.user_name')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="user.entry.email"
                                    :label="$t('g.login_email')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="email"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="user.entry.phone"
                                    :label="$t('g.phone_number')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="phone"
                                />
                            </div>
                        </template>
                        <template #form2>
                            <div class="q-pa-sm">
                                <q-input
                                    filled
                                    clearable
                                    v-model="user.entry.password"
                                    :label="$t('g.login_password')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="password"
                                    :error-message="user.errors.password"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="user.entry.password_confirmation"
                                    :label="$t('g.login_password_confirmation')"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    type="password"
                                />

                                <q-select
                                    clearable
                                    filled
                                    v-model="user.entry.role_id"
                                    :options="user.lists.roles"
                                    :label="$t('input.user.role')"
                                    option-value="id"
                                    option-label="title"
                                    :rules="[
                                        (val) =>
                                            val != null || $t('v.selected'),
                                    ]"
                                    emit-value
                                    map-options
                                />
                            </div>
                        </template>
            </form-data>
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
            if (e.newRow) {
                user.$reset();
                user.fetchCreateData();
            }
        });

        const onSubmit = () => {
            user.storeData();
        };

        const onReset = () => {
            user.entry = {};
        };
        return { table, rules, user, onSubmit, onReset };
    },
};
</script>

<style></style>
