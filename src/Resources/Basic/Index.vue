<template>
    <q-page class="">
        <data-table
            :columns="user.columns"
            :title="$t('input.user.title')"
            selection="multiple"
            router="users"
            role="user"
        >
        </data-table>
        <create-user />
        <edit-user />
        <show-user />
    </q-page>
</template>

<script setup lang="ts">
import { useUsersIndex } from "@/stores/users/index";
import CreateUser from "./Create.vue";
import EditUser from "./Edit.vue";
import ShowUser from "./Show.vue";
const user = useUsersIndex();
</script>
