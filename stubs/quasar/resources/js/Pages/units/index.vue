<script lang="ts" setup>
import { useUnitsIndex } from "@/stores/units/index";
import CreateUnit from "./create.vue"
import EditUnit from "./edit.vue"

const unit = useUnitsIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="unit.columns"
            :title="$t('input.unit.title')"
            selection="multiple"
            router="units"
            role="category"
            :viewable="false"
        >
            <template #body-cell-name="props">
                <q-td :items="props.row">
                    {{ props.items.row.name }}
                </q-td>
            </template>
        </data-table>

        <create-unit />
        <edit-unit />
    </q-page>
</template>

<style scoped></style>
