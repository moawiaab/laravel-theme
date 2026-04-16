<script lang="ts" setup>
import { useClientsIndex } from "@/stores/clients/index";
import { useClientAmounts } from "@/stores/clients/amount";
import CreateClient from "./create.vue";
import EditClient from "./edit.vue";
import ShowClient from "./show.vue";
import AmountClient from "./amount.vue";

const page = useClientsIndex();
const amount = useClientAmounts();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.columns"
            :title="$t('input.client.title')"
            selection="multiple"
            router="clients"
            role="client"
            :toggle="true"
        >
            <template #body-cell-name="props">
                <q-td
                    :items="props.row"
                    :class="props.items.row.amount < 0 ? 'deletedItem' : ''"
                >
                    {{ props.items.row.name }}
                </q-td>
            </template>

            <template #body-cell-roof="props">
                <q-td>
                    <q-chip color="red-2" text-color="red" dense square v-if="props.items.row.type == 0" label="لا يسحب غير حقه"/>
                    <q-chip color="blue-2" text-color="blue" dense square v-else-if="props.items.row.type == 2" label="سحب غير محدود"/>
                    <q-chip dense square v-else :label="props.items.row.roof"/>
                </q-td>
            </template>
            <template #options="{ props }">
                <q-btn
                    icon="add_circle"
                    dense
                    flat
                    glossy
                    rounded
                    color="blue-5"
                    @click="amount.setData(props)"
                    v-if="props.status && props.toggle"
                />
            </template>
        </data-table>

        <create-client />
        <edit-client />
        <show-client />
        <amount-client />
    </q-page>
</template>

<style scoped></style>
