<script lang="ts" setup>
import { useCategoriesIndex } from "@/stores/categories/index";
import CreateCategory from "./create.vue";
import EditCategory from "./edit.vue";
import ViewCategory from "./show.vue";

const category = useCategoriesIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="category.columns"
            :title="$t('input.category.title')"
            selection="multiple"
            router="categories"
            role="category"
        >
            <template #body-cell-name="props">
                <q-td :items="props.row">
                    {{ props.items.row.name }}
                </q-td>
            </template>
        </data-table>

        <create-category />
        <edit-category />
        <view-category />
    </q-page>
</template>

<style scoped></style>
