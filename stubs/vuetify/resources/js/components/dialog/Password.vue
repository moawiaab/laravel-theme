<template>
    <v-layout>
        <v-row justify="center">
            <v-dialog v-model="data.showPassword" persistent max-width="500" class="text-right">
                <v-form @submit.prevent="changePassword" ref="form">
                    <v-card>
                        <v-card-title class="text-h5">
                            تغيير كلمة السر
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-text-field clearable label="كلمة السر الحالية" variant="outlined"
                                hint="هنا كلمة السر المراد تغييرها" v-model="data.password.password"
                                :rules="data.rules.required" type="password" :error-messages="data.errors.password"
                                required @keyup="data.errors.password = ''" />
                            <v-text-field clearable label="كلمة السر الجديدة" variant="outlined"
                                hint="هنا كلمة السر الجديدة" v-model="data.password.newPassword"
                                :rules="data.rules.required" type="password" required
                                :error-messages="data.errors.newPassword" />
                            <v-text-field clearable label="تأكيد كلمة السر" variant="outlined"
                                hint="هنا تأكيد كلمة السر" v-model="data.password.newPassword_confirmation"
                                :rules="data.rules.required" type="password" required />
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                                @click="data.showPassword = false">
                                إلغاء الأمر
                            </v-btn>
                            <btn-save :loading="data.loading" />
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
    </v-layout>
</template>
<script lang="ts">
import { useSettingPassword } from '@/stores/settings/SettingPassword';
import { computed } from 'vue';

export default {
    setup() {
        const data = useSettingPassword()

        const formIsValid = computed(() => data.password.password && data.password.newPassword)
        const changePassword = () => {
            if (validation()) {
                data.changePassword().then(() => {
                    data.$reset()
                })
            } else {
                console.log('no')
            }
        }

        const validation = () => {
            return (
                data.password.password
                && data.password.newPassword
                && data.password.newPassword_confirmation)
        }
        return { data, changePassword }
    }
}
</script>
