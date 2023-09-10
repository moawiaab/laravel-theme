<template>
    <main-page
        :headers="headers"
        role="stage"
        title=" السنة المالية"
        :deletable="false"
        :deleteAll="false"
        :addSelected="false"
        :viewable="false"
        :createNewItem="false"
    >
        <!-- <template #create>
            <create-category />
        </template> -->

        <template #table-operation="{ item }">
            <toggle-icon
                @click="pages.toggleItem(item.id)"
                role="category"
                :toggle="item.done"
            />
        </template>

        <edit-category />
        <show-category />
    </main-page>
</template>

<script lang="ts" setup>
import CreateCategory from "./Create.vue";
import EditCategory from "./Edit.vue";
import ShowCategory from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";

const pages = usePageIndex();
pages.$reset();
pages.setup("stages");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم السنة المالية", value: "name", width: 200, sortable: true },
    { text: "تاريخ البداية", value: "start_date", width: 200, sortable: true },
    { text: "تاريخ النهاية", value: "end_date" },
    { text: "حالة القسم", value: "status" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true },
    { text: "إعدادات", value: "operation", width: 150 },
];
</script>
