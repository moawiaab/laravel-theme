<template>
    <main-page
        :headers="headers"
        role="budget"
        title="الموازنة المالية"
        :deleteAll="false"
        :addSelected="false"
        :viewable="false"
    >
        <template #create>
            <create-budget />
        </template>

        <template #table-operation="{ item }">
            <toggle-icon
                @click="pages.toggleItem(item.id)"
                role="category"
                :toggle="item.status"
            />
        </template>

        <template #item-new_amount="{item}">
            {{ parseInt(item.amount) - parseInt(item.expense) }}
        </template>

        <template #expand="item">
            <v-card>
                <v-card-title class="text-h5 text-primary"
                    >اخر خمس تحويلات</v-card-title
                >
                <v-card-text>
                    <data-table
                        :headers="headersItems"
                        :items="item.items"
                        body-text-direction="right"
                        :hide-footer="true"
                    >
                    </data-table>
                </v-card-text>
            </v-card>
        </template>

        <edit-budget />
    </main-page>
</template>

<script lang="ts" setup>
import CreateBudget from "./Create.vue";
import EditBudget from "./Edit.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";

const pages = usePageIndex();

pages.$reset();
pages.setup("budgets");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "بند الموازنة", value: "name", width: 200, sortable: true },
    { text: "المبلغ المحدد", value: "amount" },
    { text: "المبلغ المصروف", value: "expense" },
    { text: "المبلغ المتبقي", value: "new_amount" },
    { text: "عدد المعاملات", value: "num" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true },
    { text: "إعدادات", value: "operation", width: 150 },
];

const headersItems: import("vue3-easy-data-table").Header[] = [
    { text: " المبلغ", value: "amount" },
    { text: "التفاصيل", value: "details" },
    { text: "المرسل", value: "user" },
    { text: "تاريخ الارسال", value: "created_at" },
];
</script>
