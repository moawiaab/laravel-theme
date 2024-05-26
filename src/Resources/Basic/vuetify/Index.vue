<template>
  <main-page :headers="headers" role="user" :title="$t('input.user.title')">
    <template #create>
      <v-btn variant="text" @click="model.showModalCreate = true">
        {{ $t("f.add") }}</v-btn
      >
      <create-page v-if="model.showModalCreate" />
    </template>

    <edit-page />
    <show-page />
  </main-page>
</template>

<script lang="ts" setup>
import CreatePage from "./Create.vue";
import EditPage from "./Edit.vue";
import ShowPage from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("users");
const headers: import("vue3-easy-data-table").Header[] = [
  //don't remove the line
  { text: "g.created_at", value: "created_at", sortable: true }, //
  { text: "g.options", value: "operation", width: 180 },
];
</script>
