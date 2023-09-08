<script lang="ts" setup>
import { usePublicTreasuriesIndex } from "@/stores/public-treasuries/index";
import { useTables } from "@/stores/tables/index";
import { onMounted } from "vue";

const table = useTables();
const pub = usePublicTreasuriesIndex();
onMounted(() => {
    pub.fetchShowData(1);
    table.trashedData.push({ id: "new", name: "table.new" });
    table.trashedData.push({ id: "end", name: "table.end" });
});
</script>

<template>
    <q-page>
        <div class="row q-pa-sm" v-if="pub.lists.pub">
            <widgets-show-card
                icon="menu_book"
                :text="pub.lists.pub.amount"
                title="input.all.r_amount"
                color="green"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="menu_book"
                :text="pub.lists.pub.add_amount"
                title="input.all.export"
                color="blue"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="menu_book"
                :text="pub.lists.pub.take_amount"
                title="input.all.import"
                color="red"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>

        <data-table
            :columns="pub.columns"
            :title="$t('input.public.title')"
            selection="multiple"
            router="public-treasuries"
            role="private_locker"
            :editable="false"
            :viewable="false"
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
                        pub.rowId = props.id;
                        pub.alert = true;
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
                        pub.rowId = props.id;
                        pub.confirm = true;
                    "
                    v-if="props.status && !props.deleted_at"
                />
            </template>
        </data-table>
        <q-dialog v-model="pub.confirm" persistent>
            <q-card style="min-width: 350px">
                <q-card-section>
                    <div class="text-h6">{{$t('d.t1')}}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    <q-input
                        dense
                        v-model="pub.entry.details"
                        autofocus
                        @keyup.enter="pub.deleteItem()"
                    />
                </q-card-section>

                <q-card-actions class="text-primary">
                    <q-btn
                        flat
                        :label="$t('d.back')"
                        @click="pub.deleteItem()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-dialog v-model="pub.alert">
            <q-card>
                <q-card-section>
                    <div class="text-h6">{{ $t("d.amount") }}</div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    {{ $t("d.t3") }}
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        flat
                        :label="$t('d.ok')"
                        color="primary"
                        @click="pub.setDone()"
                    />
                    <q-btn flat :label="$t('d.c')" color="red" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<style scoped></style>
