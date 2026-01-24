<template>
  <m-dialog
    v-model="table.editRow"
    :title="
      $t('input.user.title_edit') + ' : ' + (table.row.name || single.entry.name)
    "
    :mh="100"
  >
    <form-data @submitted="onSubmit" @reset="onReset" class="q-gutter-md">
      <template #form1>
        <div class="q-pa-sm">inputsItem</div>
      </template>

      <template #form2> Set Details Her </template>
      <template #actions>
        <q-btn
          flat
          :label="$t('g.update')"
          type="submit"
          color="primary"
          class="bg-blue-1"
          :loading="single.loading"
        />
        <q-btn
          :label="$t('g.reset')"
          type="reset"
          color="warning"
          flat
          class="q-ml-sm bg-yellow-1"
        />
        <q-btn
          flat
          :label="$t('g.close')"
          v-close-popup
          color="negative"
          class="bg-red-1"
        />
      </template>
    </form-data>
  </m-dialog>
</template>

<script setup lang="ts">
import { useTables } from "@/stores/tables/index";
import { useForms } from "@/Composables/rules";
import { useUsersIndex } from "@/stores/users/index";
import { watch } from "@vue/runtime-core";


const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useUsersIndex();

watch(table, (e) => {
  if (e.editRow) {
    single.fetchEditData(table.row.id);
  }
});

const onSubmit = () => {
  single.updateData(table.row.id);
};

const onReset = () => {
  single.entry = {};
};
</script>

<style></style>
