<template>
    <v-dialog v-model="single.showModalEdit" persistent max-width="600" class="text-right">
        <v-form @submit.prevent="submitForm" ref="form">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    تعديل إذن الدخول
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field clearable label="اسم الصلاحية" variant="solo" color="primary" hint="هنا اسم الصلاحية "
                        v-model="single.entry.details" :rules="rules.required" :error-messages="single.errors.details"
                        required />
                    <v-text-field clearable label="الرابط" variant="solo" color="primary"
                        hint="رابط الصلاحية يجب عن تكون بالانجليزية حتى لا توجه مشاكل" v-model="single.entry.title"
                        :rules="rules.required" required :error-messages="single.errors.title" />

                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal" @click="single.showModalEdit = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script>
import { ref, computed } from "vue";
import { useSinglePermissions } from '../../stores/permissions/single';
import { useSettingAlert } from '../../stores/settings/SettingAlert';

export default {
    name: "EditPermission",
    setup() {
        const single = useSinglePermissions();
        const rules = {
            password: [(val) => val < 10 || `I don't believe you!`],
            required: [
                (val) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => single.updateData().then(() => {
            if (validation()) {
                single.updateData().then(() => {
                    single.showModalEdit = false;
                    single.$reset();
                })
            } else {
                useSettingAlert().setAlert("لا تترك حقل فارغ لو سمحت", 'warning', true)
            }
        })
        const validation = () => {
            return (
                single.entry.details
                && single.entry.title)
        }
        return {
            single,
            submitForm,
            rules
        }
    },

}
</script>
