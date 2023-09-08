<script setup>
import { useOrdersIndex } from "@/stores/orders/index";
import { useTables } from "@/stores/tables/index";
import PrintPage from "@/Components/print/page.vue";

import { ref, watch } from "vue";
const orderData = ref(null);

const table = useTables();
const page = useOrdersIndex();

const printOrder = async (data) => {
    orderData.value = data;
};

const columns = [
    { name: "id", label: "#" },
    { name: "total", label: "القيمة - Amount" },
    { name: "num", label: "الكمية - Qty" },
    { name: "name", label: "البيان  - Description" },
    { name: "price", label: "سعر الوحدة - Price" },
];

const refresh = () => (orderData.value = null);
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.columns"
            :title="$t('input.order.title')"
            selection="multiple"
            router="orders"
            role="order"
            :viewable="false"
            :editable="false"
            :newRow="false"
            :creatable="true"
            :expand="true"
            :deletable="false"
        >
            <template #table-body="{ props }">
                <q-table :rows="props.row.items" :columns="page.supOrder">
                    <template #body-cell-num="props">
                        <q-td>
                            <q-chip square :label="props.row.num" />
                            <q-chip
                                v-if="props.row.back > 0"
                                square
                                :label="`${$t('input.all.back')} : ${
                                    props.row.back
                                }`"
                                color="red-1"
                                class="text-red"
                            />
                        </q-td>
                    </template>
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

                            <q-btn
                                glossy
                                icon="mdi-backup-restore"
                                dense
                                flat
                                rounded
                                color="red"
                                @click="
                                    page.childId = props.row.id;
                                    page.backOne = true;
                                "
                                v-if="!props.row.status && props.row.backed"
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
                <q-btn
                    glossy
                    icon="mdi-printer"
                    dense
                    flat
                    rounded
                    color="primary"
                    @click="$htmlToPaper('printMe', null, () => refresh())"
                    v-if="orderData"
                />
                <q-btn
                    glossy
                    icon="mdi-printer-outline"
                    dense
                    flat
                    rounded
                    color="primary"
                    @click="printOrder(props)"
                    v-if="!props.status && !orderData"
                />
                <q-btn
                    glossy
                    icon="mdi-backup-restore"
                    dense
                    flat
                    rounded
                    color="red"
                    @click="
                        page.childId = props.id;
                        page.backId = true;
                    "
                    v-if="!props.status && props.backed"
                />
            </template>
        </data-table>

        <q-dialog v-model="page.alert">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("input.order.r1") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("input.order.r2") }}
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
                    <div class="text-h6">{{ $t("input.order.r3") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("input.order.r4") }}
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

        <q-dialog v-model="page.backId">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("input.order.r5") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("input.order.r6") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('d.ok')"
                        color="primary"
                        @click="page.setBack()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="page.backOne">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("input.order.r7") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("input.order.r8") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('d.ok')"
                        color="primary"
                        @click="page.setBackOne()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <print-page
            v-if="orderData"
            :display="false"
            title="ok"
            :rows="orderData.items"
            :columns="columns"
            bodyStyle="padding:50px; "
        >
            <template #body>
                <tr
                    v-for="(i, id) in orderData.items"
                    :key="id"
                    style="width: 100%"
                >
                    <td
                        style="
                            border: 1px solid #ccc;
                            border-top: none;
                            text-align: center;
                        "
                    >
                        {{ id + 1 }}
                    </td>
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.total }}
                    </td>
                    <td
                        style="
                            border: 1px solid #ccc;
                            border-top: none;
                            text-align: center;
                        "
                    >
                        {{ i.num }}
                    </td>
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.name }}
                    </td>
                    <td style="border: 1px solid #ccc; border-top: none">
                        {{ i.price }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ccc"></td>
                    <td style="border: 1px solid #ccc">
                        {{ orderData.amount }}
                    </td>
                    <td style="border: 1px solid #ccc">الجملة كتابة</td>
                    <td
                        colspan="2"
                        style="
                            background-color: #f0f0f0 !important;
                            border: 1px solid #ccc;
                        "
                    ></td>
                </tr>
            </template>
        </print-page>
    </q-page>
</template>

<style scoped></style>
