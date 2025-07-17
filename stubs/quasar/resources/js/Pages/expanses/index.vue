<script lang="ts" setup>
import { onMounted, ref } from "vue";
import { useExpansesIndex } from "@/stores/expanses/index";
import { useTables } from "@/stores/tables/index";
import CreateExpanse from "./create.vue";
import ViewExpanse from "./show.vue";

const table = useTables();
const expanse = useExpansesIndex();
onMounted(() => {
    table.trashedData.push({ id: "new", name: "table.new" });
    table.trashedData.push({ id: "end", name: "table.end" });
});
</script>

<template>
    <q-page class="">
        <data-table
            :columns="expanse.columns"
            :title="$t('input.expanse.title')"
            selection="multiple"
            router="expanses"
            role="expanse"
            :editable="false"
            :deletable="false"
        >
            <template #options="{ props }">
                <q-btn
                    glossy
                    icon="mdi-check-outline"
                    dense
                    flat
                    rounded
                    color="primary"
                    @click="
                        expanse.rowId = props.id;
                        expanse.alert = true;
                    "
                    v-if="props.status"
                />

                <q-btn
                    glossy
                    icon="delete"
                    dense
                    flat
                    rounded
                    color="red"
                    @click="
                        expanse.rowId = props.id;
                        expanse.confirm = true;
                    "
                    v-if="props.status && !props.deleted_at"
                />
            </template>
        </data-table>
        <q-dialog v-model="expanse.confirm" persistent>
            <q-card style="min-width: 350px">
                <q-card-section>
                    <div class="text-h6">{{ $t("g.d.t1") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    <q-input
                        dense
                        v-model="expanse.data.details"
                        autofocus
                        @keyup.enter="expanse.deleteItem()"
                    />
                </q-card-section>

                <q-card-actions class="text-primary">
                    <q-btn
                        flat
                        :label="$t('g.back')"
                        @click="expanse.deleteItem()"
                    />
                    <q-btn
                        flat
                        :label="$t('g.d.c')"
                        color="red"
                        v-close-popup
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-dialog v-model="expanse.alert">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("g.d.amount") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("g.d.t2") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('g.d.ok')"
                        color="primary"
                        @click="expanse.setDone()"
                    />
                    <q-btn
                        flat
                        :label="$t('g.d.c')"
                        color="red"
                        v-close-popup
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
        <create-expanse />
        <!-- <page-edits-expanse/> -->
        <view-expanse />
    </q-page>
</template>

<style scoped></style>
