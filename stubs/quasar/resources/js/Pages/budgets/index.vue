<script lang="ts" setup>
import CreateBudget from "./create.vue";
import EditBudget from "./edit.vue";
import ViewBudget from "./show.vue";
import { useBudgetsIndex } from "@/stores/budgets/index";

const account = useBudgetsIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="account.columns"
            :title="$t('input.budget.title')"
            selection="multiple"
            router="budgets"
            role="budget"
            :expand="true"
            :toggle="true"
        >
            <template #table-body="{ props }">
                <q-table
                    :rows="props.row.items"
                    :columns="account.expanseList"
                    :rows-per-page-options="[0]"
                >
                    <template #header="props">
                        <q-tr :props="props">
                            <q-th
                                v-for="col in props.cols"
                                :key="col.name"
                                :props="props"
                            >
                                {{ $t(col.label) }}
                            </q-th>
                        </q-tr>
                    </template>
                </q-table>
            </template>
        </data-table>

        <create-budget />
        <edit-budget />
        <view-budget />
    </q-page>
</template>

<style scoped></style>
