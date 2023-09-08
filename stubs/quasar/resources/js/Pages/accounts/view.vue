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
                    {{$t('input.account.view')}} :
                    {{ table.row.name || account.entry.name }}
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
                                <q-item>
                                    <q-item-label
                                        >
                                        {{$t('input.account.name')}} :
                                        {{ account.entry.name }}</q-item-label
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-label
                                        >
                                        {{$t('g.phone_number')}} :
                                        {{ account.entry.phone }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >
                                        {{$t('input.account.details')}} :
                                        {{
                                            account.entry.details
                                        }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >
                                        {{$t('input.account.user_count')}} :
                                        {{ account.entry.role }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >
                                        {{$t('input.account.role_count')}} :
                                        {{ account.entry.user }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >
                                        {{$t('g.created_at')}} :
                                        {{
                                            account.entry.created_at
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
import { useAccountIndex } from "@/stores/accounts/index";
import { useSettings } from "@/stores/settings";
import {watch} from "vue"

const settings = useSettings();
const table = useTables();

const account = useAccountIndex();

watch(table, (e) => {
    if (e.showRow) {
        account.fetchShowData(table.row.id);
    }
});

const onSubmit = () => {
    account.storeData();
};

const onReset = () => {
    account.entry = {};
};
</script>

<style></style>
