<template>
    <v-dialog
        v-model="single.showModalCreateController"
        persistent
        max-width="900"
        scrollable
    >
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    create new controller
                </v-card-title>
                <v-divider />
                <div class="ma-2">
                    <v-text-field
                        clearable
                        label="Controller Name"
                        hint="If You Like Set UserController Entre User Only"
                        variant="solo"
                        v-model="single.form.controller"
                        :rules="rules.required"
                        :error-messages="single.errors.name"
                        required
                        color="primary"
                    />
                    <div class="text-gary">
                        Controller :
                        {{ single.ucFirst(single.form.controller) }}Controller
                    </div>
                    <div class="">
                        Model :
                        {{ single.ucFirst(single.form.controller) }}
                    </div>
                    <div class="">
                        Resource :
                        {{ single.ucFirst(single.form.controller) }}Resource
                    </div>
                    <div class="">
                        Require :
                        {{ single.ucFirst(single.form.controller) }}Require
                    </div>
                    <v-divider />
                    <v-row class="mt-1">
                        <v-col>
                            <v-text-field
                                density="compact"
                                clearable
                                label="Column Name"
                                variant="solo"
                                v-model="single.entry.name"
                                color="primary"
                                hide-details
                            />
                        </v-col>

                        <v-col>
                            <v-select
                                density="compact"
                                v-model="single.entry.type"
                                clearable
                                label="Select Column Type"
                                :items="single.options"
                                variant="solo"
                                hide-details
                                @update:modelValue="single.setType"
                            />
                        </v-col>
                        <v-col cols="auto">
                            <v-checkbox
                                label="Require"
                                v-model="single.entry.require"
                                size="md"
                                hide-details
                            />
                        </v-col>
                        <v-col>
                            <v-text-field
                                density="compact"
                                clearable
                                label="Default value"
                                variant="solo"
                                v-model="single.entry.value"
                                color="primary"
                                append-icon="mdi-plus-circle"
                                @click:append="single.addItem"
                                hide-details
                            />
                        </v-col>
                    </v-row>

                    <table-form
                        :columns="single.columns"
                        :rows="single.form.items"
                    />
                </div>
                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="single.showModalCreateController = false"
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
                single.storeData().then(() => {
                    single.showModalCreateController = false;
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
