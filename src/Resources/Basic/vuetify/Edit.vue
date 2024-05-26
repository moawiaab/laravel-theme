<template>
  <v-dialog v-model="model.showModalEdit" persistent max-width="800" scrollable>
    <v-form @submit.prevent="submitForm" ref="form">
      <v-card>
        <v-card-title class="text-h5 text-primary">
          {{ $t("input.user.title_edit") }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text> inputsItem </v-card-text>

        <v-divider />
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red-darken-1"
            prepend-icon="mdi-close"
            variant="tonal"
            @click="model.showModalEdit = false"
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
import { useSingleUsers } from "../../stores/users/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { watch } from "@vue/runtime-core";

export default {
  name: "EditUser",
  setup() {
    const single = useSingleUsers();
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
          (val || "").length > 0 || "لا تترك هذا الحقل فارغاً لو سمحت",
      ],
    };

    const validation = () => {
      return (validationFiled true);
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
