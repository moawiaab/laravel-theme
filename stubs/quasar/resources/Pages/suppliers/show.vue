<template>
    <q-dialog
        v-model="table.showRow"
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                    {{$t('input.supplier.view')}} :
                    {{ table.row.name || single.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter
                    v-model="single.splitterModel"
                    style="height: 100%"
                    :limits="[25, 50]"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list separator>
                                <q-item>
                                    <q-item-label
                                        >  {{$t('input.supplier.name')}}:
                                        {{ single.entry.name }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        > {{$t('g.email')}}:
                                        {{ single.entry.email }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        > {{$t('g.phone_number')}}:
                                        {{ single.entry.phone }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        > {{$t('input.all.r_amount')}}:
                                        {{ single.entry.amount }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{$t('g.address')}}:
                                        {{ single.entry.address }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                       {{$t('input.all.createBy')}}:
                                        {{ single.entry.user }}</q-item-label
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-label
                                        > {{$t('g.created_at')}}:
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
                            :rows="single.lists.items"
                            :columns="single.amountColumns"
                        >
                            <template #top-left>
                                <div class="text-red">
                                    {{$t('input.supplier.r1')}}
                                </div>
                            </template>

                            <template #top-right>
                                <q-btn
                                    :label="$t('input.supplier.r2')"
                                    flat
                                    dense
                                    color="info"
                                    :to="`/suppliers/${single.entry.id}/amounts/${single.entry.name}`"
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
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    flat
                    :label="$t('g.close')"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useSuppliersIndex } from "@/stores/suppliers/index";
import { useSettings } from "@/stores/settings";
import { watch } from "vue";
const settings = useSettings();
const table = useTables();

const single = useSuppliersIndex();

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
