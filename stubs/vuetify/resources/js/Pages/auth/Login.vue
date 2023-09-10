<template>
    <v-card-title
        class="text-center mb-3 text-xs-h6 text-md-h5 text-lg-h4 font-weight-black text-deep-purple-accent-2"
        color="red"
        >تسجيل دخول</v-card-title
    >
    <v-form @submit.prevent="submitForm">
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

        <v-checkbox
            v-model="single.entry.terms"
            color="primary"
            label="حفظ كلمة السر"
        ></v-checkbox>
        <btn-save :loading="single.loading" :block="true" text="تسجيل دخول" />

        <router-link to="/password/reset">
            <v-list-item>فقد كلمة السر</v-list-item></router-link
        >
        <router-link to="/register">
            <v-list-item> إنشاء حساب جديد</v-list-item></router-link
        >
    </v-form>
</template>

<script lang="ts">
import { useSingleAuth } from "../../stores/auth/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { watch } from "@vue/runtime-core";
import { useRouter } from "vue-router";

export default {
    name: "Login Page",
    props: ["icon"],
    setup() {
        const router = useRouter();
        const single = useSingleAuth();
        watch(single, (e) => {
            if (e.showModalCreate) {
                single.fetchCreateData();
            }
        });

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
        return {
            single,
            rules,
            submitForm,
        };
    },
};
</script>
