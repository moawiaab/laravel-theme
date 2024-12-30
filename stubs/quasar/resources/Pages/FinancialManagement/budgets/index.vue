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
            :expand="false"
            :toggle="true"
        >
            <template #body-cell-knob="props">
                <q-td>
                    <q-knob
                        readonly
                        v-model="props.items.row.knob"
                        size="40px"
                        :thickness="0.4"
                        center-color="grey-5"
                        show-value
                        :color="
                            props.items.row.knob < 40
                                ? 'green'
                                : props.items.row.knob > 80
                                ? 'red'
                                : 'orange'
                        "
                        :track-color="
                            props.items.row.knob < 40
                                ? 'green-2'
                                : props.items.row.knob > 80
                                ? 'red-2'
                                : 'orange-2'
                        "
                    >
                        {{ props.items.row.knob }}%</q-knob
                    >
                </q-td>
            </template>
        </data-table>

        <create-budget />
        <edit-budget />
        <view-budget />
    </q-page>
</template>

<style scoped></style>
