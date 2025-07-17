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
                    {{$t('input.budget_name.view')}} :
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
                                    :label="`${$t('input.budget_name.name')} : ${budget.entry.name}`"
                                />
                                <item-label
                                    :label="`${$t('g.details')} : ${budget.entry.details}`"
                                />
                                <item-label
                                    :label="`${$t('input.budget_name.status')} : ${budget.entry.budget_type}`"
                                />
                                <item-label
                                    :label="`${$t('g.type')} : ${budget.entry.budget_status}`"
                                />
                                <item-label
                                    :label="`${$t('input.budget_name.num')} : ${budget.entry.num}`"
                                />
                                <item-label
                                    :label="`${$t('g.created_at')} : ${budget.entry.created_at}`"
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
import { useBudgetNameIndex } from "@/stores/budget-names/index";
import { useSettings } from "@/stores/settings";
import {watch} from "vue"
const settings = useSettings();
const table = useTables();

const budget = useBudgetNameIndex();

watch(table, (e) => {
    if (e.showRow) {
        budget.fetchShowData(table.row.id);
    }
});

const onSubmit = () => {
    budget.storeData();
};

const onReset = () => {
    budget.entry = {};
};
</script>

<style></style>
