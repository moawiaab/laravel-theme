<script lang="ts" setup>
import { useStagesIndex } from "@/stores/stages/index";
import TreeItem from "./treeItem.vue";

const stage = useStagesIndex();
</script>

<template>
    <q-page padding>
        <data-table
            :columns="stage.columns"
            title="السنوات المالية"
            selection="multiple"
            router="stages"
            role="stage"
            :expand="true"
            :deletable="false"
            :viewable="false"
            :editable="false"
        >
            <template #table-body="{ props }">
                <tree-item :stages="props.row.stages" v-if="props.row.stages" />

            </template>
        </data-table>
    </q-page>
</template>

<style scoped></style>
