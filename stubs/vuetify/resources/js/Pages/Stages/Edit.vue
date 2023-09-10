<template>
    <v-dialog v-model="model.showModalEdit" persistent max-width="500" scrollable>
        <v-form @submit.prevent="submitForm" ref="form">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    تعديل بيانات القسم
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field clearable label="السنة المالية" variant="solo" hint="هنا اسم السنة المالية"
                        v-model="single.entry.name" :rules="rules.required"
                        :error-messages="single.errors.name" required color="primary" />
                    <v-text-field clearable label="فترة البداية" variant="solo" hint="هنا فترة البداية "
                        v-model="single.entry.start_date" :rules="rules.required"
                        :error-messages="single.errors.start_date" required color="primary" type="date" />
                    <v-text-field clearable label="فترة النهاية" variant="solo" hint="هنافترة النهاية "
                        v-model="single.entry.end_date" :rules="rules.required" :error-messages="single.errors.end_date"
                        required color="primary" type="date" />
                </v-card-text>

                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                        @click="model.showModalEdit = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>


<script lang="ts">
import { useSingleStages } from '../../stores/stages/single';
import { useSettingAlert } from '../../stores/settings/SettingAlert';
import { useSinglePage } from '../../stores/pages/pageSingle';
import { watch } from '@vue/runtime-core';

export default {
    name: "EditUser",
    setup() {
        const single = useSingleStages();
        const model = useSinglePage()
        watch(model, (e) => {
            if (e.showModalEdit) {
                single.$reset()
                single.setupEntry(model.entry, [])
            }
        })
        const submitForm = () => single.updateData().then(() => {
            if (validation()) {
                single.updateData().then(() => {
                    model.showModalEdit = false;
                    single.$reset();
                    model.entry = {}
                })
            } else {
                useSettingAlert().setAlert("لا تترك حقل فارغ لو سمحت", 'warning', true)
            }
        })

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const validation = () => {
            return (single.entry.start_date && single.entry.end_date && single.entry.name)
        }

        return {
            single,
            submitForm,
            rules,
            model
        }
    },

}
</script>
