<template>
    <v-btn variant="text" @click="model.showModalCreate = true">إضافة بند موازنة</v-btn>
    <v-dialog v-model="model.showModalCreate" persistent max-width="400" scrollable>
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة بند موازنة جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field clearable label="اسم البند" variant="solo" hint="هنا اسم البند للمصروف"
                        v-model="single.entry.name" :rules="rules.required"
                        :error-messages="single.errors.name" required color="primary" />
                    <v-text-field clearable label="مبلغ الموازنة" variant="solo" hint="هنا مبلغ الموازنة"
                        v-model="single.entry.amount" :rules="rules.required"
                        :error-messages="single.errors.amount" required color="primary" type="number" />

                        <v-select v-model="single.entry.stage_id" clearable label="السنة المالية"
                                :items="single.lists.stages" variant="solo" item-title="name" item-value="id">
                            </v-select>

                </v-card-text>

                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                        @click="model.showModalCreate = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts">
import { useSingleExpanses } from '../../stores/expanses/single';
import { useSettingAlert } from '../../stores/settings/SettingAlert';
import { useSinglePage } from '../../stores/pages/pageSingle';
import { watch } from 'vue';

export default {
    name: "CreateExpanse",
    setup() {
        const single = useSingleExpanses();
        const model = useSinglePage();
        watch(model, (e) => {
            if (e.showModalCreate) {
                single.$reset()
                single.setupEntry(model.entry, model.lists)
                console.log(model.lists)
            }
        })

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
                    model.showModalCreate = false;
                    single.$reset();
                    model.entry = {}
                })
            } else {
                useSettingAlert().setAlert("لا تترك حقل فارغ لو سمحت", 'warning', true)
            }
        }
        const validation = () => {
            return (single.entry.name && single.entry.amount)
        }
        return {
            model,
            single,
            rules,
            submitForm,
        }
    },

}
</script>
