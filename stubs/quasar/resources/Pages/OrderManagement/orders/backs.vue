<script lang="ts" setup>
import { useOrdersIndex } from "@/stores/orders/index";
import { useTables } from "@/stores/tables/index";
import { watch, ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const options = [
    { name: t("input.back.o1"), id: 1 },
    { name: t("input.back.o2"), id: 0 },
];
const table = useTables();
const page = useOrdersIndex();
const type = ref<number>(1);

watch(type, (e: number) => {
    table.filters.type = e;
    table.getData();
});
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.columnsBack"
            :title="$t('input.back.title')"
            selection="multiple"
            router="order-backs"
            role="order"
            :viewable="false"
            :editable="false"
            :newRow="false"
            :creatable="false"
            :deletable="false"
        >
            <template #filter>
                <q-select
                    v-model="type"
                    dense
                    options-dense
                    :options="options"
                    option-label="name"
                    option-value="id"
                    emit-value
                    map-options
                    options-cover
                    style="min-width: 100px"
                />
            </template>
            <template #options="{ props }">
                <q-btn
                    glossy
                    icon="mdi-check-outline"
                    dense
                    flat
                    rounded
                    color="primary"
                    @click="
                        page.rowId = props.id;
                        page.confirm = true;
                    "
                    v-if="props.status"
                />
            </template>
        </data-table>

        <q-dialog v-model="page.confirm">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("input.back.t1") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("input.back.t2") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('d.ok')"
                        color="primary"
                        @click="page.doneBack()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<style scoped></style>
