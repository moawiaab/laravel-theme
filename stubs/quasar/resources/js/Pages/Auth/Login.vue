<template>
    <q-page class="row items-center justify-around">
        <div class="q-pa-md" style="width: 400px">
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-input
                    filled
                    clearable
                    v-model="login.email"
                    :label="$t('g.login_email')"
                    lazy-rules
                    :rules="[(val) => !!val || $t('v.required')]"
                    type="email"
                />

                <q-input
                    filled
                    type="password"
                    v-model="login.password"
                    :label="$t('g.login_password')"
                    lazy-rules
                    :rules="[(val) => !!val || $t('v.required')]"
                    clearable
                />
                <q-toggle
                    v-model="login.remember"
                    :label="$t('g.remember_me')"
                />

                <!-- <q-btn

                    label="إنشاء حساب جديد"
                    flat
                    class="q-ml-sm"
                    to="/register"
                /> -->
                <div>
                    <q-btn
                        :label="$t('g.login')"
                        type="submit"
                        color="primary"
                    />
                    <q-btn
                        :label="$t('g.reset')"
                        type="reset"
                        color="primary"
                        flat
                        class="q-ml-sm"
                    />
                </div>
            </q-form>
        </div>
    </q-page>
</template>

<script setup>
import TextFilled from "@/Components/input/TextFilled.vue";
import { useQuasar } from "quasar";
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useForms } from "../../Composables/rules";
import { useAuth } from "@/stores/auth/index";

const { login: loginData, rules: rulesData } = useForms();
const login = loginData;
const rules = rulesData;

const auth = useAuth();

const $q = useQuasar();
const router = useRouter();

const errors = ref();

const onSubmit = () => {
    axios
        //   .post('/login', form.value)
        .request({
            baseURL: "/",
            url: "login",
            method: "post",
            params: login.value,
        })
        .then(async (res) => {
            // await auth.setRoles();
            accessData();
        })
        .catch((err) => {
            console.log(err.errors);
            errors.value = err.message;
            $q.notify({
                color: "red-5",
                textColor: "white",
                icon: "warning",
                message: "تحقق من البريد الكتروني أو كلمة السر",
            });
        });
};
const accessData = () => {
    axios
        .get("abilities")
        .then((res) => {
            console.log(res.data);
            // ability.update([{ action: res.data.data, subject: "all" }]);
            auth.can = res.data.data;
            auth.userData = res.data.user;
            location.reload();
        })
        .catch((err) => {
            console.log(err);
        });
};

const onReset = () => {
    console.log("res.data");
    login.value.email = "";
    login.value.password = "";
};
</script>
