<script lang="ts" setup>
import { useStoresIndex } from "@/stores/stores/index";
import CreateStore from "./create.vue";
import EditStore from "./edit.vue";
import ShowStore from "./Show.vue";

const store = useStoresIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="store.columns"
            :title="$t('input.store.title')"
            selection="multiple"
            router="stores"
            role="category"
            :toggle="true"
            :expand="true"
        >
            <template #table-body="{ props }">
                <q-table :rows="props.row.products" :columns="store.productColumns" title="show 10 Products">
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

        <create-store />
        <edit-store />
        <show-store />
    </q-page>
</template>

<style scoped></style>
