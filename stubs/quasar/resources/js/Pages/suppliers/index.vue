<script lang="ts" setup>
import { useSuppliersIndex } from "@/stores/suppliers/index";
import { useSupplierAmounts } from "@/stores/suppliers/amount";
import CreateSupplier from "./create.vue"
import EditSupplier from "./edit.vue"
import ShowSupplier from "./show.vue"
import ChildSupplier from "./amount.vue"

const page = useSuppliersIndex();
const amount = useSupplierAmounts();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.columns"
            :title="$t('input.supplier.title')"
            selection="multiple"
            router="suppliers"
            role="supplier"
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

        <create-supplier />
        <edit-supplier />
        <show-supplier />
        <child-supplier />
    </q-page>
</template>

<style scoped></style>
