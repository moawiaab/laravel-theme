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
                    {{ $t("input.category.view") }} :
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
                                        >{{ $t("input.category.name") }}:
                                        {{ single.entry.name }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.details") }} :
                                        {{ single.entry.details }}</q-item-label
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
                                        {{ $t("g.type") }} :
                                        {{ single.entry.status }}</q-item-label
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
                            :rows="single.lists.items"
                            :columns="single.columnsProduct"
                        >
                            <template #top-left>
                                <div class="text-red">
                                    {{ $t("input.category.r1") }}
                                </div>
                            </template>

                            <template #top-right>
                                <q-btn
                                    :label="$t('input.client.r2')"
                                    flat
                                    dense
                                    color="info"
                                    :to="`/clients/${single.entry.id}/amounts-${single.entry.name}`"
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
                <q-btn flat :label="$t('d.c')" v-close-popup color="negative" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useCategoriesIndex } from "@/stores/categories/index";
import { useSettings } from "@/stores/settings";
import { watch } from "vue";
const settings = useSettings();
const table = useTables();

const single = useCategoriesIndex();

watch(table, (e) => {
    if (e.showRow) {
        single.fetchShowData(table.row.id);
    }
});
</script>

<style></style>
