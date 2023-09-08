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
                <q-td :items="props.row">
                    {{ props.items.row.name }}
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
