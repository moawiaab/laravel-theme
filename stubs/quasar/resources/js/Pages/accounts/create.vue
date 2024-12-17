<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{ $t("input.account.title_new") }}</div>
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
                                <q-item-label caption class="q-ma-sm">
                                    {{ $t("input.account.description") }}
                                </q-item-label>
                                <q-input
                                    filled
                                    clearable
                                    v-model="account.entry.br_name"
                                    :label="$t('input.account.name')"
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    :error="
                                        account.errors.br_name ? true : false
                                    "
                                    :error-message="account.errors.br_name"
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
                                    :error="
                                        account.errors.details ? true : false
                                    "
                                    :error-message="account.errors.details"
                                >
                                    <template #append>
                                        <q-icon name="info" />
                                    </template>
                                </q-input>

                                <!-- <q-item-label class="q-ma-sm">تفاصيل الفرع</q-item-label>
                <q-editor toolbar-push v-model="account.entry.details" min-height="4rem"  /> -->
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
                                <q-item-label caption class="q-ma-sm">
                                    {{ $t("input.account.admin") }}
                                </q-item-label>
                                <q-input
                                    filled
                                    clearable
                                    lazy-rules
                                    v-model="account.entry.name"
                                    :label="$t('g.user_name')"
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    :error="account.errors.name ? true : false"
                                    :error-message="account.errors.name"
                                >
                                    <template #append>
                                        <q-icon name="person" />
                                    </template>
                                </q-input>

                                <q-input
                                    filled
                                    clearable
                                    lazy-rules
                                    v-model="account.entry.email"
                                    :label="$t('g.login_email')"
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    type="email"
                                    :error="account.errors.email ? true : false"
                                    :error-message="account.errors.email"
                                >
                                    <template #append>
                                        <q-icon name="email" />
                                    </template>
                                </q-input>
                                <q-input
                                    filled
                                    clearable
                                    lazy-rules
                                    v-model="account.entry.password"
                                    :label="$t('g.login_password')"
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    :type="`${locker ? 'password' : 'text'}`"
                                    :error="
                                        account.errors.password ? true : false
                                    "
                                    :error-message="account.errors.password"
                                >
                                    <template #append>
                                        <q-icon
                                            :name="`${
                                                locker ? 'lock' : 'visibility'
                                            }`"
                                            @click="locker = !locker"
                                            class="cursor-pointer"
                                        />
                                    </template>
                                </q-input>

                                <q-input
                                    filled
                                    clearable
                                    lazy-rules
                                    v-model="
                                        account.entry.password_confirmation
                                    "
                                    :rules="[(val) => !!val || $t('v.required')]"
                                    :type="`${locker ? 'password' : 'text'}`"
                                    :error="
                                        account.errors.password ? true : false
                                    "
                                    :error-message="account.errors.password"
                                    :label="$t('g.login_password_confirmation')"
                                >
                                    <template #append>
                                        <q-icon
                                            :name="`${
                                                locker ? 'lock' : 'visibility'
                                            }`"
                                            @click="locker = !locker"
                                            class="cursor-pointer"
                                        />
                                    </template>
                                </q-input>
                            </div>
                        </template>
                    </q-splitter>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
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
