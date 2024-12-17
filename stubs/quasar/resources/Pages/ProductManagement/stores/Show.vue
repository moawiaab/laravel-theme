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
                    {{ $t("input.store.view") }} :
                    {{ table.row.name || store.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter v-model="store.splitterModel" style="height: 100%">
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list>
                                <q-item>
                                    <q-item-label
                                        >{{ $t("input.store.name") }} :
                                        {{ table.row.name }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.details") }} :
                                        {{ table.row.details }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label>
                                        {{ $t("g.created_at") }} :
                                        {{ table.row.created_at }}</q-item-label
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
                        <div class="q-pa-sm" v-if="store.data">
                            <q-table
                            v-if="store.data"
                                :rows="store.data"
                                :columns="store.productColumns"
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
                        </div>
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

<script>
import { useTables } from "../../stores/tables/index";
import { useStoresIndex } from "../../stores/stores/index";
import { useSettings } from "@/stores/settings";
import { watch } from "vue";
const settings = useSettings();

const table = useTables();
const store = useStoresIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.showRow) {
                store.data = [];
                store.fetchShowData(table.row.id);
            }
        });

        return { table, store, settings };
    },
};
</script>

<style></style>
