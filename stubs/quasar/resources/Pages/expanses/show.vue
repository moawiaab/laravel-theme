<template>
    <q-dialog
        v-model="table.showRow"
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">
                       {{$t('input.expanse.view')}} :
                    {{ table.row.name || single.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter
                    v-model="table.splitterModel"
                    style="height: 100%"
                    :limits="[25, 50]"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list separator>
                                <item-label
                                    :label="`${$t('input.expanse.name')} : ${single.entry.name}`"
                                />
                                <item-label
                                    :label="`${$t('input.all.amount')} : ${single.entry.amount}`"
                                />

                                <item-label
                                    :label="`${$t('g.amount_text')} : ${single.entry.text_amount}`"
                                />
                                <item-label
                                    :label="`${$t('input.expanse.beneficiary')} : ${single.entry.beneficiary}`"
                                />

                                <item-label
                                    :label="`${$t('d.details')} : ${single.entry.details}`"
                                />
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
                        <div class="q-pa-sm">
                            <q-list separator>
                                <item-label
                                    :label="`${$t('g.type')} : ${
                                        single.entry.status ? 'جديدة' : 'مكتملة'
                                    }`"
                                />
                                <item-label
                                    :label="`${$t('input.all.createBy')} : ${single.entry.user}`"
                                />
                                <item-label
                                    :label="`${$t('g.created_at')} : ${single.entry.created_at}`"
                                />
                                <item-label
                                    :label="`${$t('input.all.admin')} : ${single.entry.admin}`"
                                />

                                <item-label
                                    :label="`${$t('input.all.send_date')} : ${single.entry.updated_at}`"
                                />
                                <item-label
                                    :label="`${$t('input.expanse.details')} : ${single.entry.deleted_at}`"
                                    v-if="single.entry.deleted_at"
                                />
                                <item-label
                                    v-if="single.entry.feeding"
                                    :label="`${$t('input.expanse.details')} : ${single.entry.feeding}`"
                                />
                            </q-list>
                        </div>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    flat
                    :label="$t('d.c')"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useExpansesIndex } from "@/stores/expanses/index";
import { useSettings } from "@/stores/settings";
import {watch} from "vue"
const settings = useSettings();
const table = useTables();

const single = useExpansesIndex();

watch(table, (e) => {
    if (e.showRow) {
        single.fetchShowData(table.row.id);
    }
});
</script>

<style></style>
