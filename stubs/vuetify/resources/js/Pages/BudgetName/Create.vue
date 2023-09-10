<template>
    <v-btn variant="text" @click="model.showModalCreate = true"
        >إضافة اسم موازنة</v-btn
    >
    <v-dialog
        v-model="model.showModalCreate"
        persistent
        max-width="500"
        scrollable
    >
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة اسم موازنة جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field
                        clearable
                        label="اسم الموازنة"
                        v-model="single.entry.name"
                        :rules="rules.required"
                        :error-messages="single.errors.name"
                        required
                        color="primary"
                    />
                    <v-textarea
                        clearable
                        label=" تفاصيل اسم الموازنة"
                        v-model="single.entry.details"
                        :rules="rules.required"
                        :error-messages="single.errors.details"
                        required
                        color="primary"
                    />

                    <v-select
                        v-model="single.entry.type"
                        clearable
                        label="نوع اسم الموازنة"
                        :items="single.lists.type"
                        variant="solo"
                        item-title="name"
                        item-value="id"
                    >
                    </v-select>
                </v-card-text>

                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="model.showModalCreate = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts">
import { useSingleBudgetName } from "../../stores/budgetName/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { watch } from "vue";

export default {
    name: "CreateExpanse",
    setup() {
        const single = useSingleBudgetName();
        const model = useSinglePage();
        watch(model, (e) => {
            if (e.showModalCreate) {
                single.$reset();
                single.setupEntry(model.entry, model.lists);
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
                    model.showModalCreate = false;
                    single.$reset();
                    model.entry = {};
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
            return single.entry.name && single.entry.details;
        };
        return {
            model,
            single,
            rules,
            submitForm,
        };
    },
};
</script>
