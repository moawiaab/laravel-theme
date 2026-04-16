<template>
    <m-dialog v-model="table.newRow" :title="$t('input.account.title_new')" :mh="100">
        <form-data @submitted="onSubmit" @reset="onReset" class="q-gutter-md" :loading="account.loading">
            <template #form1>
                <div class="q-pa-sm">
                    <q-item-label caption class="q-ma-sm">
                        {{ $t("input.account.description") }}
                    </q-item-label>

                    <m-input
                        v-model="account.entry.br_name"
                        :label="$t('input.account.name')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="account.errors.br_name"
                        icon="mdi-source-branch"
                    />

                    <m-input
                        v-model="account.entry.phone"
                        :label="$t('g.two_factor.phone_number')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="account.errors.phone"
                        icon="phone"
                        type="phone"
                    />

                    <m-input
                        v-model="account.entry.details"
                        :label="$t('input.account.details')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        type="textarea"
                        icon="info"
                        :error="account.errors.details"
                    />

                    <!-- <q-item-label class="q-ma-sm">تفاصيل الفرع</q-item-label>
                <q-editor toolbar-push v-model="account.entry.details" min-height="4rem"  /> -->
                </div>
            </template>

            <template #form2>
                <div class="q-pa-sm">
                    <q-item-label caption class="q-ma-sm">
                        {{ $t("input.account.admin") }}
                    </q-item-label>
                    <m-input
                        v-model="account.entry.name"
                        :label="$t('g.user_name')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="account.errors.name"
                        icon="person"
                    />

                    <m-input
                        v-model="account.entry.email"
                        :label="$t('g.login_email')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        type="email"
                        :error="account.errors.email"
                        icon="email"
                    />
                    <q-input
                        filled
                        clearable
                        lazy-rules
                        v-model="account.entry.password"
                        :label="$t('g.login_password')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :type="`${locker ? 'password' : 'text'}`"
                        :error="account.errors.password ? true : false"
                        :error-message="account.errors.password"
                    >
                        <template #append>
                            <q-icon
                                :name="`${locker ? 'lock' : 'visibility'}`"
                                @click="locker = !locker"
                                class="cursor-pointer"
                            />
                        </template>
                    </q-input>

                    <q-input
                        filled
                        clearable
                        lazy-rules
                        v-model="account.entry.password_confirmation"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :type="`${locker ? 'password' : 'text'}`"
                        :error="account.errors.password ? true : false"
                        :error-message="account.errors.password"
                        :label="$t('g.login_password_confirmation')"
                    >
                        <template #append>
                            <q-icon
                                :name="`${locker ? 'lock' : 'visibility'}`"
                                @click="locker = !locker"
                                class="cursor-pointer"
                            />
                        </template>
                    </q-input>
                </div>
            </template>

        </form-data>
    </m-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useAccountIndex } from "@/stores/accounts/index";
import { useSettings } from "@/stores/settings";
const settings = useSettings();
import { useForms } from "@/Composables/Forms";
import { ref, watch } from "vue";

defineProps({
    name: "CreatesAccount",
});

const locker = ref(true);
const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const account = useAccountIndex();
watch(table, (e) => {
    if (e.newRow) {
        account.$reset();
        account.fetchCreateData();
    }
});

const onSubmit = () => {
    account.storeData();
};

const onReset = () => {
    account.entry = {};
};
</script>

<style></style>
