<template>
    <q-page class="row items-center justify-around">
        <div class="q-pa-md" style="width: 800px">
            <div class="text-h5 text-center q-pb-md">إنشاء حساب جديد</div>
            <q-separator inset />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-splitter v-model="auth.splitterModel" style="height: 100%">
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-input
                                clearable
                                filled
                                v-model="register.name"
                                label="الاسم بالكامل"
                                lazy-rules
                                :rules="[(val) => !!val || $t('v.required')]"
                            />
                            <q-input
                                clearable
                                filled
                                v-model="register.email"
                                label="البريد الالكتروني * "
                                lazy-rules
                                :rules="[(val) => !!val || $t('v.required')]"
                                type="email"
                            />
                            <q-input
                                clearable
                                filled
                                v-model="register.phone"
                                label="رقم الهاتف"
                                lazy-rules
                                :rules="[(val) => !!val || $t('v.required')]"
                                type="phone"
                            />
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
                            <q-input
                                filled
                                clearable
                                v-model="register.password"
                                label="كلمة السر"
                                lazy-rules
                                :rules="[(val) => !!val || $t('v.required')]"
                                type="password"
                            />
                            <q-input
                                clearable
                                filled
                                v-model="register.password_confirmation"
                                label=" تأكيد كلمة السر"
                                lazy-rules
                                :rules="[(val) => !!val || $t('v.required')]"
                                type="password"
                            />
                            <q-input
                                clearable
                                filled
                                v-model="register.age"
                                label="تاريخ الميلاد"
                                lazy-rules
                                :rules="[(val) => !!val || $t('v.required')]"
                                type="date"
                            />
                        </div>
                    </template>
                </q-splitter>
                <q-input
                    class="q-px-sm"
                    clearable
                    filled
                    v-model="register.details"
                    label=" مزيد من التفاصيل"
                    lazy-rules
                    :rules="[(val) => !!val || $t('v.required')]"
                />
                <q-separator inset />
                <q-btn
                    label="لدي حساب بالفعل"
                    flat
                    class="q-ml-sm"
                    to="/login"
                />
                <div>
                    <q-btn label="دخول" type="submit" color="primary" />
                    <q-btn
                        label="تفريغ الحقول"
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

const { register: loginData, rules: rulesData } = useForms();
const register = loginData;
const rules = rulesData;

const auth = useAuth();

const $q = useQuasar();
const router = useRouter();

const form = ref({
    email: "",
    password: "",
    remember: false,
});

const errors = ref();

const name = ref(null);
const age = ref(null);
const accept = ref(false);

const onSubmit = () => {
    axios
        //   .post('/login', form.value)
        .request({
            baseURL: "/",
            url: "register",
            method: "post",
            params: register.value,
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
            // console.log(res.data);
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
