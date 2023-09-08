<script lang="ts" setup>
import { useBudgetNameIndex } from "@/stores/budget-names/index";

import CreateBudget from "./create.vue";
import EditBudget from "./edit.vue";
import ViewBudget from "./show.vue";

const account = useBudgetNameIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="account.columns"
            :title="$t('input.budget_name.title')"
            selection="multiple"
            router="budget-names"
            role="budget_name"
            :toggle="true"
        >
        </data-table>

        <create-budget />
        <edit-budget />
        <view-budget />
    </q-page>
</template>

<style scoped></style>
