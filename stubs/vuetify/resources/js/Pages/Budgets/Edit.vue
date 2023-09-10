<template>
    <v-dialog
        v-model="model.showModalEdit"
        persistent
        max-width="500"
        scrollable
    >
        <v-form @submit.prevent="submitForm" ref="form">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    تعديل بيانات القسم
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field
                        clearable
                        label="اسم البند"
                        variant="solo"
                        v-model="single.entry.name"
                        required
                        color="primary"
                        disabled
                    />
                    <v-text-field
                        clearable
                        label="مبلغ الموازنة"
                        variant="solo"
                        hint="هنا مبلغ الموازنة"
                        v-model="single.entry.amount"
                        :rules="rules.required"
                        :error-messages="single.errors.amount"
                        required
                        color="primary"
                        type="number"
                    />
                </v-card-text>

                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="model.showModalEdit = false"
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
import { useSingleBudgets } from "../../stores/budgets/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { watch } from "@vue/runtime-core";

export default {
    name: "EditExpanse",
    setup() {
        const single = useSingleBudgets();
        const model = useSinglePage();
        watch(model, (e) => {
            if (e.showModalEdit) {
                single.$reset();
                single.setupEntry(model.entry, model.lists);
            }
        });
        const submitForm = () =>
            single.updateData().then(() => {
                if (validation()) {
                    single.updateData().then(() => {
                        model.showModalEdit = false;
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
            });

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const validation = () => {
            return (
                single.entry.amount
            );
        };

        return {
            single,
            submitForm,
            rules,
            model,
        };
    },
};
</script>
