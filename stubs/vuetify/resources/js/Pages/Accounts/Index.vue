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
  { text: "اسم الفرع", value: "name", width: 200, sortable: true },
  { text: "تفاصيل الفرع", value: "details", width: 200 },
  { text: "رقم الهاتف", value: "phone", sortable: true },
  { text: "عدد المستخدمين", value: "user", sortable: true },
  { text: "عدد الصلاحيات", value: "role" },
  { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
//   { text: "إعدادات", value: "operation", width: 150 },
];
</script>

