<template>
    <q-dialog
        v-model="settings.password"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 30vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">تغيير كلمة السر</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            filled
                            clearable
                            v-model="settings.entry.current_password"
                            label="كلمة السر الحالية * "
                            :rules="[(val) => !!val || $t('v.required')]"
                            :type="`${locker ? 'password' : 'text'}`"
                            :error="
                                settings.errors.current_password ? true : false
                            "
                            :error-message="settings.errors.current_password"
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
                            v-model="settings.entry.password"
                            label="كلمة السر جديدة * "
                            :rules="[(val) => !!val || $t('v.required')]"
                            :type="`${locker ? 'password' : 'text'}`"
                            :error="settings.errors.password ? true : false"
                            :error-message="settings.errors.password"
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
                            v-model="settings.entry.password_confirmation"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :type="`${locker ? 'password' : 'text'}`"
                            :error="
                                settings.errors.password_confirmation
                                    ? true
                                    : false
                            "
                            :error-message="
                                settings.errors.password_confirmation
                            "
                            label=" تأكيد كلمة السر *"
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
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label=" تغيير كلمة السر"
                        type="submit"
                        color="primary"
                        :loading="settings.loading"
                    />
                    <q-btn
                        label="تفريغ الحقول"
                        type="reset"
                        color="warning"
                        flat
                        class="q-ml-sm"
                    />
                    <q-btn
                        flat
                        label="قفل النافذة"
                        v-close-popup
                        color="negative"
                    />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { useForms } from "@/Composables/Forms";
import { useSettings } from "@/stores/settings";
import { ref } from "vue";
const settings = useSettings();

const locker = ref(true);
const { rules: rulesData } = useForms();
const rules = rulesData;

const onSubmit = () => {
    settings.setPassword();
};

const onReset = () => {
    settings.entry = {};
};
</script>

<style></style>
