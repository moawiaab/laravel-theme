<template>
    <v-dialog
        v-model="single.showModalCreateReq"
        persistent
        max-width="500"
        scrollable
    >
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    create new Resources
                </v-card-title>
                <v-divider />
                <div class="ma-2">
                    <v-text-field
                        clearable
                        label="Resources Name"
                        hint="If You Like Set UserResources Entre User Only"
                        variant="solo"
                        v-model="single.form.controller"
                        :rules="rules.required"
                        :error-messages="single.errors.name"
                        required
                        color="primary"
                    />
                    <v-divider />

                </div>
                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="single.showModalCreateReq = false"
                    >
                        {{ $t("g.close") }}
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts">
import { useDevelopmentIndex } from "../../stores/development";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import TableForm from "./TableForm.vue";

export default {
    name: "CreateUser",
    components: { TableForm },
    setup() {
        const single = useDevelopmentIndex();

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => {
            if (validation()) {
                single.form.tab = "request"
                single.submittedData().then(() => {
                    single.showModalCreateReq = false;
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
            return single.form.controller;
        };
        return {
            single,
            rules,
            submitForm,
        };
    },
};
</script>
