<template>
  <main-page :headers="headers" role="user" title="عرض الفروع"  :createNewItem="false">
    <!-- <template #create>
      <v-btn variant="text" @click="model.showModalCreate = true"> إضافة</v-btn>
      <create-user v-if="model.showModalCreate" />
    </template> -->
    <edit-user />
    <show-user />
  </main-page>
</template>

<script lang="ts" setup>
import CreateUser from "./Create.vue";
import EditUser from "./Edit.vue";
import ShowUser from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("accounts");
const headers: import("vue3-easy-data-table").Header[] = [
  { text: 'input.account.name', value: "name", width: 200, sortable: true },
  { text: "g.details", value: "details", width: 200 },
  { text: "g.phone_number", value: "phone", sortable: true },
  { text: "input.account.user_count", value: "user", sortable: true },
  { text: "input.account.role_count", value: "role" },
  { text: "g.created_at", value: "created_at", sortable: true }, //
//   { text: "إعدادات", value: "operation", width: 150 },
];
</script>

