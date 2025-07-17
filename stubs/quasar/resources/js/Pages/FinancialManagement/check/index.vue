<template>
    <q-page class="">
        <div class="row q-pa-sm">
            <widgets-show-card
                icon="mdi-bank-transfer-in"
                :text="
                    sum(table.data, 1)
                "
                title="input.check.in"
                color="blue"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer-out"
                :text=" sum(table.data, 0)"
                title="input.check.out"
                color="red"
                subTitle="ج/س"
                class="q-mr-xs"
            />
            <widgets-show-card
                icon="mdi-bank-transfer"
                :text="
                    sum(table.data, 1) -
                    sum(table.data, 0)
                "
                title="input.check.last"
                color="green"
                subTitle="ج/س"
                class="q-mr-xs"
            />
        </div>

        <data-table
            :columns="check.columns"
            :title="$t('input.check.title')"
            selection="multiple"
            router="checks"
            role="check"
        >
            <template #body-cell-type="props">
                <q-td :items="props.row">
                    <q-avatar
                        icon="mdi-arrow-up"
                        color="red-2"
                        text-color="red"
                        size="md"
                        v-if="props.items.row.type == 0"
                    />
                    <q-avatar
                        icon="mdi-arrow-down"
                        color="green-2"
                        text-color="green"
                        size="md"
                        v-else
                    />
                </q-td>
            </template>

            <template #body-cell-options="props">
                <q-td class="text-right">
                    <q-btn
                        glossy
                        icon="mdi-check-outline"
                        dense
                        flat
                        rounded
                        color="primary"
                        @click="check.setDone(props.items.row.id)"
                        v-if="props.items.row.status"
                    />
                </q-td>
            </template>
        </data-table>
    </q-page>
</template>

<script setup lang="ts">
import { useChecksIndex } from "@/stores/check/index";
import { useTables } from "@/stores/tables/index";

const check = useChecksIndex();
const table = useTables();

const sum = (obj: any, data: number) => {
    var sum = 0;
    let ab = obj.forEach((element: any) => {
        if (element.status == 1 && element.type == data)
            sum += parseFloat(element.amount);
    });

    return isNaN(sum) ? 0 : sum.toFixed(1);
};
</script>
