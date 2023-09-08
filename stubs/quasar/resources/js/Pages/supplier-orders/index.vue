<script lang="ts" setup>
import { useSupplierOrdersIndex } from "@/stores/supplier-orders/index";
import { useTables } from "@/stores/tables/index";

const table = useTables();
const page = useSupplierOrdersIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.columns"
            :title="$t('input.supOrder.title')"
            selection="multiple"
            router="supplier-orders"
            role="supplier_order"
            :viewable="false"
            :editable="false"
            :newRow="false"
            :creatable="true"
            :expand="true"
            :deletable="false"
        >
            <template #table-body="{ props }">
                <q-table :rows="props.row.items" :columns="page.supOrder">
                    <template #body-cell-options="props">
                        <q-td class="text-right">
                            <q-btn
                                glossy
                                icon="mdi-check-outline"
                                dense
                                flat
                                rounded
                                color="primary"
                                @click="
                                    page.childId = props.row.id;
                                    page.alert = true;
                                "
                                v-if="props.row.status"
                            />
                        </q-td>
                    </template>
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

            <template #options="{ props }">
                <q-btn
                    glossy
                    icon="mdi-check-outline"
                    dense
                    flat
                    rounded
                    color="primary"
                    @click="
                        page.rowId = props.id;
                        page.confirm = true;
                    "
                    v-if="props.status"
                />
            </template>
        </data-table>

        <q-dialog v-model="page.alert">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("d.t4") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("d.t5") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('d.ok')"
                        color="primary"
                        @click="page.setDone()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-dialog v-model="page.confirm">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("d.t6") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("d.t7") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('d.ok')"
                        color="primary"
                        @click="page.delete()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<style scoped></style>
