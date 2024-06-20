<template>
    <q-page class="">
        <data-table
            :columns="page.columns"
            :title="$t('input.user.title')"
            selection="multiple"
            router="users"
            role="user"
        >
        </data-table>
        <create-page />
        <edit-page />
        <show-page />
    </q-page>
</template>

<script setup lang="ts">
import { useUsersIndex } from "@/stores/users/index";
import CreatePage from "./Create.vue";
import EditPage from "./Edit.vue";
import ShowPage from "./Show.vue";
const page = useUsersIndex();
</script>
