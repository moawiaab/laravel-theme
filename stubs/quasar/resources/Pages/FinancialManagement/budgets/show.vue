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
                   {{$t('input.budget.view')}} :
                    {{ table.row.name || budget.entry.name }}
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
                                    :label="`${$t('input.budget.name')} : ${budget.entry.name}`"
                                />
                                <item-label
                                    :label="`${$t('input.budget.amount')}: ${budget.entry.amount}`"
                                />
                                <item-label
                                    :label="`${$t('input.budget.expense')}: ${budget.entry.expense}`"
                                />
                                <item-label
                                    :label="`${$t('input.budget.num_r')}: ${
                                        budget.entry.amount -
                                        budget.entry.expense
                                    }`"
                                />
                                <item-label
                                    :label="`${$t('input.budget.num')}: ${budget.entry.num}`"
                                />
                                <item-label
                                    :label="`${$t('g.created_at')}: ${budget.entry.created_at}`"
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
                        <div class="q-pa-sm">details</div>
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
import { useBudgetsIndex } from "@/stores/budgets/index";
import { useSettings } from "@/stores/settings";
import {watch} from "vue"
const settings = useSettings();
const table = useTables();

const budget = useBudgetsIndex();

watch(table, (e) => {
    if (e.showRow) {
        budget.fetchShowData(table.row.id);
    }
});

</script>

<style></style>
