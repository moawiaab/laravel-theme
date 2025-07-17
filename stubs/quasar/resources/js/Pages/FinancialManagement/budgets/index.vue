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
            <template #optionsItem="{ props }">
                <q-td class="q-pa-none q-ma-none">
                    <q-knob
                        class="q-ma-none q-pa-none"
                        readonly
                        v-model="props.knob"
                        size="40px"
                        :thickness="0.4"
                        center-color="grey-5"
                        show-value
                        :color="
                            props.knob < 40
                                ? 'green'
                                : props.knob > 80
                                ? 'red'
                                : 'orange'
                        "
                        :track-color="
                            props.knob < 40
                                ? 'green-2'
                                : props.knob > 80
                                ? 'red-2'
                                : 'orange-2'
                        "
                    >
                        {{ props.knob }}%</q-knob
                    >
                </q-td>
            </template>

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

<style>
.q-table td {
    padding: 1px 16px !important;
    background-color: inherit;
}
</style>
