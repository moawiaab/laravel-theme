<template>
    <main-page
        :headers="headers"
        role="budget_name"
        title="اسماء الموازنة"
        :deleteAll="false"
        :addSelected="false"
        :viewable="false"
    >
        <template #expand="item">
            {{ item }}
        </template>
        <template #create>
            <create-budget-name />
        </template>

        <template #table-operation="{ item }">
            <toggle-icon
                @click="pages.toggleItem(item.id)"
                role="budget_name"
                :toggle="item.status"
                v-if="!item.type"
            />
        </template>

        <edit-budget-name />
        <!-- <show-budget-name /> -->
    </main-page>
</template>

<script lang="ts" setup>
import CreateBudgetName from "./Create.vue";
import EditBudgetName from "./Edit.vue";
// import ShowBudgetName from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSettingAlert } from "../../stores/settings/SettingAlert";

const pages = usePageIndex();

pages.$reset();
pages.setup("budget-names");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم الموازنة", value: "name", width: 200, sortable: true },
    { text: " تفاصيل الموازنة", value: "details" },
    { text: " نوع الموازنة", value: "budget_type" },
    { text: " حالة الموازنة", value: "budget_status" },
    { text: "عدد الموازنات", value: "num" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true },
    { text: "إعدادات", value: "operation", width: 150 },
];
</script>
