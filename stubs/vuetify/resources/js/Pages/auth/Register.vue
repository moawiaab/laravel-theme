<template>
    <v-card-title
        class="text-center mb-3 text-xs-h6 text-md-h5 text-lg-h4 font-weight-black text-deep-purple-accent-2"
        color="red"
    >
        إنشاء حساب جديد</v-card-title
    >
    <v-form @submit.prevent="submitForm">
        <v-tab value="tab-1" :color="tab === 'tab-1' && 'info'">
            <v-icon>mdi-account-alert-outline</v-icon>
            بيانات المستخدم
        </v-tab>

        <v-tab value="tab-2" :color="tab === 'tab-2' && 'info'">
            <v-icon>mdi-bank</v-icon>
            بيانات الحساب
        </v-tab>

        <v-window v-model="tab">
            <v-window-item value="tab-1">
                <v-text-field
                    clearable
                    label="اسم المستخدم"
                    variant="solo"
                    hint="هنا اسم المستخدم "
                    v-model="single.entry.userName"
                    color="primary"
                    :rules="rules.required"
                    :error-messages="single.errors.userName"
                />
                <v-text-field
                    clearable
                    label=" البريد الالكتروني"
                    variant="solo"
                    hint="هنا البريد الالكتروني "
                    v-model="single.entry.email"
                    color="primary"
                    type="email"
                    :rules="rules.required"
                    :error-messages="single.errors.email"
                />
                <v-text-field
                    clearable
                    label="كلمة السر "
                    variant="solo"
                    v-model="single.entry.password"
                    :rules="rules.required"
                    :error-messages="single.errors.password"
                    required
                    color="primary"
                    type="password"
                />

                <v-text-field
                    clearable
                    label="تأكيد كلمة السر "
                    variant="solo"
                    v-model="single.entry.password_confirmation"
                    :rules="rules.required"
                    :error-messages="single.errors.password_confirmation"
                    required
                    color="primary"
                    type="password"
                />
            </v-window-item>

            <v-window-item value="tab-2">
                <v-text-field
                    clearable
                    label=" اسم المحل التجاري "
                    variant="solo"
                    hint=" هنا اسم المحل التجاري "
                    v-model="single.entry.name"
                    color="primary"
                    :rules="rules.required"
                    :error-messages="single.errors.name"
                />
                <v-text-field
                    clearable
                    label="رقم الهاتف "
                    variant="solo"
                    hint=" رقم الهاتف "
                    v-model="single.entry.phone"
                    color="primary"
                    type="phone"
                    :rules="rules.required"
                    :error-messages="single.errors.phone"
                />

                <v-text-field
                    clearable
                    label="تفاصيل المحل التجاري"
                    variant="solo"
                    hint="هنا تفاصيل المحل التجاري "
                    v-model="single.entry.details"
                    color="primary"
                    :rules="rules.required"
                    :error-messages="single.errors.details"
                />

                <v-select
                    v-model="single.entry.type"
                    clearable
                    label="نوع المتجر"
                    :items="single.lists.items"
                    variant="solo"
                    item-title="title"
                    item-value="id"
                >
                </v-select>
            </v-window-item>
        </v-window>

        <btn-save
            v-if="tab === 'tab-1'"
            color="green"
            type="button"
            text="التالي"
            icon="mdi-skip-forward-outline"
            @click="nextTab(true)"
        />
        <btn-save
            v-if="tab === 'tab-2'"
            color="green"
            type="button"
            text="رجوع"
            icon="mdi-skip-backward-outline"
            @click="nextTab(false)"
        />
        <btn-save
            :loading="single.loading"
            v-if="tab === 'tab-2'"
            text="إنشاء الحساب"
            class="mx-2"
        />
    </v-form>
    <router-link to="/login">
        <v-list-item> لدي حساب بالفعل</v-list-item></router-link
    >
</template>

<script lang="ts">
import { useSingleRegister } from "../../stores/auth/Register";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { ref, watch } from "@vue/runtime-core";
import { useRouter } from "vue-router";

export default {
    name: "Login Page",
    props: ["icon"],
    setup() {
        const router = useRouter();
        const single = useSingleRegister();
        const tab = ref();
        single.entry.type = 1;

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => {
            if (validation()) {
                single.storeData().then(() => {
                    router.push("/dashboard");
                    single.$reset();
                });
            } else {
                useSettingAlert().setAlert(
                    "لا تترك حقل فارغ لو سمحت",
                    "warning",
                    true
                );
            }
        };
        const validation = () => {
            return single.entry.email && single.entry.password;
        };

        const nextValidation = () => {
            return (
                single.entry.email &&
                single.entry.password &&
                single.entry.password_confirmation &&
                single.entry.userName
            );
        };

        const nextTab = (item: Boolean) => {
            if (item && nextValidation()) tab.value = "tab-2";
            else tab.value = "tab-1";
        };
        return {
            single,
            rules,
            submitForm,
            tab,
            nextTab,
        };
    },
};
</script>
