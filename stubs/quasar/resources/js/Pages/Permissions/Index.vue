<template>
    <q-page class="">
        <data-table
            :columns="permission.columns"
            :title="$t('input.permission.title')"
            selection="multiple"
            router="permissions"
            role="permission"
            :viewable="false"
        >
            <!-- <template #body-cell-name="props">
                <q-td :items="props.row">
                    {{ props.items.row.name }}
                </q-td>
            </template> -->
        </data-table>
        <create-permission />
        <edit-permission />
    </q-page>
</template>

<script setup lang="ts">
import { usePermissionsIndex } from "@/stores/permissions/index";
import CreatePermission from "./Create.vue";
import EditPermission from "./Edit.vue";
const permission = usePermissionsIndex();
</script>
