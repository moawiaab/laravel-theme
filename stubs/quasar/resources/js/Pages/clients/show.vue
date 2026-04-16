<template>
    <m-dialog
        v-model="table.showRow"
        :title="`${$t('input.client.view')} :  ${table.row.name || single.entry.name}`"
        :w="80"
        mh="100"
    >
        <q-card>
            <q-card-section class="q-pt-none">
                <q-splitter
                    :horizontal="$q.platform.is.mobile"
                    v-model="single.splitterModel"
                    style="height: 100%"
                    :limits="[25, 50]"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list separator>
                                <q-item>
                                    <q-item-label>
                                        {{ $t("input.client.name") }} :
                                        {{ single.entry.name }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.email") }}:
                                        {{ single.entry.email }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.phone_number") }}:
                                        {{ single.entry.phone }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("input.all.r_amount") }}:
                                        {{ single.entry.amount }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("input.client.roof") }}:
                                        {{ single.entry.roof }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.address") }} :
                                        {{ single.entry.address }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("input.all.createBy") }}:
                                        {{ single.entry.user }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("input.client.type") }} :
                                        {{
                                            single.entry.type_label
                                        }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.created_at") }} :
                                        {{
                                            single.entry.created_at
                                        }}</q-item-label
                                    >
                                </q-item>
                            </q-list>
                        </div>
                    </template>

                    <template v-slot:separator>
                        <q-avatar
                            color="primary"
                            text-color="white"
                            size="20px"
                            icon="drag_indicator"
                        />
                    </template>

                    <template v-slot:after>
                        <!-- <div class="q-pa-sm">{{single.lists.items}}</div> -->
                        <q-table
                            v-if="single.lists.items"
                            :rows="single.lists.items"
                            :columns="single.amountColumns"
                            :rows-per-page-options="[0]"
                        >
                            <template #top-left>
                                <div class="text-red">
                                    {{ $t("input.client.r1") }}
                                </div>
                            </template>

                            <template #top-right>
                                <q-btn
                                    :label="$t('input.client.r2')"
                                    flat
                                    dense
                                    color="info"
                                    :to="`/clients/${single.entry.id}/amounts/${single.entry.name}`"
                                />
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

                        <q-table
                            v-if="single.lists.orders"
                            :rows="single.lists.orders"
                            :columns="single.orderColumns"
                            :rows-per-page-options="[0]"
                            title="فواتير العميل"
                        >
                            <template #header="props">
                                <q-tr :props="props">
                                    <q-th auto-width />
                                    <q-th
                                        v-for="col in props.cols"
                                        :key="col.name"
                                        :props="props"
                                    >
                                        {{ $t(col.label) }}
                                    </q-th>
                                </q-tr>
                            </template>

                            <template #body="props">
                                <q-tr>
                                    <q-td auto-width>
                                        <q-btn
                                            glossy
                                            size="sm"
                                            color="accent"
                                            round
                                            dense
                                            @click="
                                                props.expand = !props.expand
                                            "
                                            :icon="
                                                props.expand ? 'remove' : 'add'
                                            "
                                        />
                                    </q-td>
                                    <template v-for="col in props.cols">
                                        <q-td
                                            v-if="col.name != 'options'"
                                            :key="col.name"
                                            :props="props"
                                        >
                                            {{ col.value }}
                                        </q-td>
                                    </template>
                                </q-tr>
                                <q-tr v-show="props.expand" :props="props">
                                    <q-td colspan="100%">
                                        <q-table
                                            :rows="props.row.items"
                                            :columns="single.supOrder"
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
                                    </q-td>
                                </q-tr>
                            </template>
                        </q-table>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="text-teal">
                <q-btn
                    flat
                    :label="$t('g.close')"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
        </q-card>
    </m-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useClientsIndex } from "@/stores/clients/index";
import { useSettings } from "@/stores/settings";
import { watch, ref } from "vue";
const settings = useSettings();
const table = useTables();

const single = useClientsIndex();
const expanded = ref();

watch(table, (e) => {
    if (e.showRow) {
        single.fetchShowData(table.row.id);
    }
});

const onSubmit = () => {
    single.storeData();
};

const onReset = () => {
    single.entry = {};
};
</script>

<style></style>
