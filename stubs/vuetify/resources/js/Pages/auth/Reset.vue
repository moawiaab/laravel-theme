<template>
    <v-card-title
        class="text-center mb-3 text-xs-h6 text-md-h5 text-lg-h4 font-weight-black text-deep-purple-accent-2"
        color="red"
    >
          إعادة كملة السر</v-card-title
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
        <btn-save :loading="single.loading" />
    </v-form>
</template>

<script lang="ts">
import { useSingleAuth } from "../../stores/auth/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { watch } from "@vue/runtime-core";
import { useRouter } from 'vue-router';

export default {
    name: "Login Page",
    props: ["icon"],
    setup() {
        const single = useSingleAuth();
        const router = useRouter()
        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => {
            if (validation()) {
                single.resetPassword().then(() => {
                    router.push('/login')
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
            return single.entry.email;
        };
        return {
            single,
            rules,
            submitForm,
        };
    },
};
</script>
