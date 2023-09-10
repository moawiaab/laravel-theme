<template>
    <v-btn variant="text" @click="thisModal = !thisModal"> إضافة إذن </v-btn>
    <v-dialog v-model="thisModal" persistent max-width="600">
        <v-form @submit.prevent="submitForm" ref="form">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة إذن دخول جديد
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
                <v-divider />
                <v-row>
                    <v-col>
                        <v-list-item-title class="mx-3 text-blue-accent-4">الاسم الظاهر للصلاحية</v-list-item-title>
                        <v-list-item v-for="i in single.details" :key="i" :title="i + single.entry.details" />
                    </v-col>
                    <v-divider vertical inset />
                    <v-col>
                        <v-list-item-title class="mx-3 text-blue-accent-4"> رباط الصلاحية</v-list-item-title>
                        <v-list-item v-for="i in single.title" :key="i" :title="single.entry.title + i" />
                    </v-col>
                </v-row>
                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal" @click="thisModal = false">
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
    name: "CreatePermission",
    setup() {
        let thisModal = ref(false);
        const single = useSinglePermissions();
        const localAlert = useSettingAlert()
        const rules = {
            password: [(val) => val < 10 || `I don't believe you!`],
            required: [
                (val) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };
        const submitForm = () => {
            if (validation()) {
                single.storeData().then(() => {
                    thisModal.value = false;
                    single.$reset();
                })
            } else {
                localAlert.setAlert("لا تترك حقل فارغ لو سمحت", 'warning', true)
            }
        }
        const validation = () => {
            return (
                single.entry.details
                && single.entry.title)
        }
        return {
            thisModal,
            single,
            submitForm,
            rules
        }
    },
}
</script>
