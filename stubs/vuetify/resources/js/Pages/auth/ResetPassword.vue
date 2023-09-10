<template>
    <v-card-title
        class="text-center mb-3 text-xs-h6 text-md-h5 text-lg-h4 font-weight-black text-deep-purple-accent-2"
        color="red"
    >
        إنشاء كلمة سر جديدة</v-card-title
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
        <btn-save :loading="single.loading" />
    </v-form>


</template>

<script lang="ts">
import { useSingleRegister } from "../../stores/auth/Register";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { onMounted, ref, watch } from "@vue/runtime-core";
import { useRoute } from "vue-router";

export default {
    name: "Login Page",
    props: ["icon"],

    setup() {
        const proams = ref();
        const query = ref();
        const single = useSingleRegister();
        watch(single, (e) => {
            if (e.showModalCreate) {
                single.fetchCreateData();
            }
        });
        onMounted(() => {
            single.token = useRoute().params;
            single.entry.email = useRoute().query.email?.toString;

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
                single.resetPassword().then(() => {
                    single.showModalCreate = false;
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
            proams,
            query,
        };
    },
};
</script>
