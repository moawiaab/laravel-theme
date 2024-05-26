<template>
    <v-dialog
        v-model="model.showModalCreate"
        persistent
        max-width="800"
        scrollable
    >
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    {{ $t("input.user.title_new") }}
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-row>
                        <v-col>
                            inputsItem
                        </v-col>
                        <v-divider vertical />
                        <v-col>
                            set details
                        </v-col>
                    </v-row>
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
                       {{ $t('g.close')  }}
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts">
import { useSingleUsers } from "../../stores/users/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import {  onMounted } from "@vue/runtime-core";

export default {
    name: "CreateUser",
    setup() {
        const single = useSingleUsers();
        const model = useSinglePage();

        onMounted(() => {
            if (model.showModalCreate) {
                single.$reset();
                single.setupEntry({}, model.lists);
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
            return (validationFiled true);
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
