<template>
    <main-page
        :headers="headers"
        role="role"
        title="الصلاحيات"
        expand
        :viewable="false"
        :deleteAll="false"
        :addSelected="false"
    >
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-role v-if="model.showModalCreate" />
        </template>
        <template #expand="{ item }">
            <Splitpanes class="default-theme" style="height: 100%" :rtl="true">
                <Pane>
                    <v-list-item-title
                        >الأذونات لهذه الصلاحية</v-list-item-title
                    >
                    <v-chip
                        color="red"
                        class="ma-1"
                        v-for="{ id, details } in item.permissions"
                        :key="id"
                        size="small"
                        prepend-icon="mdi-link-lock"
                    >
                        {{ details }}
                    </v-chip>
                </Pane>
                <v-divider vertical />
                <Pane>
                    <v-list-item-title
                        >المستخدمين لهذه الصلاحية</v-list-item-title
                    >
                    <v-chip
                        color="primary"
                        class="ma-1"
                        v-for="{ id, name } in item.users"
                        :key="id"
                        size="small"
                        prepend-icon="mdi-account-circle-outline"
                        >{{ name }}
                    </v-chip>
                </Pane>
            </Splitpanes>
        </template>
        <edit-role />
        <show-role />
    </main-page>
</template>
<script lang="ts" setup>
import CreateRole from "./Create.vue";
import EditRole from "./Edit.vue";
import ShowRole from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";
import  { Splitpanes , Pane } from "splitpanes";
import type { Header } from "vue3-easy-data-table";

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("roles");
const headers: Header[] = [
    {
        text: "اسم الصلاحية",
        value: "title",
        sortable: true,
    },
    { text: "عدد الصلاحيات", value: "permissions.length" },
    { text: "عدد المستخدمين", value: "users.length" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation" },
];
</script>

<style>
/* .text-left-col {} */
</style>
