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
                    عرض بيانات اسم الموازنة :
                    {{ table.row.name || locker.entry.name }}
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
                                    :label="` صاحب الخزنة  : ${locker.entry.name}`"
                                />
                                <item-label
                                    :label="` الرصيد الفعلي : ${locker.entry.amount}`"
                                />
                                <item-label
                                    :label="` الباقي من اخر تحويلة : ${locker.entry.problem}`"
                                />
                                <item-label
                                    :label="` عند فتح الخزنة : ${locker.entry.on_open}`"
                                />
                                <item-label
                                    :label="` تاريخ الانشاء : ${locker.entry.created_at}`"
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
                        <div class="">
                            <q-table
                                :rows="locker.entry.items"
                                :columns="OpenDate"
                            >
                            </q-table>
                        </div>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    flat
                    label="قفل النافذة"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { usePrivateLockersIndex } from "@/stores/private-lockers/index";
import { useSettings } from "@/stores/settings";
import { OpenDate } from "@/types/columns";
import {watch} from "vue"
const settings = useSettings();
const table = useTables();

const locker = usePrivateLockersIndex();

watch(table, (e) => {
    if (e.showRow) {
        locker.fetchShowData(table.row.id);
    }
});

const onSubmit = () => {
    locker.storeData();
};

const onReset = () => {
    locker.entry = {};
};
</script>

<style></style>
