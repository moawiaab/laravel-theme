<template>
    <v-icon icon="mdi-pencil-outline" color="green" class="mx-1" v-if="can(`${role}_edit`,  'all')" />
</template>

<script lang="ts">
import { useAbility } from '@casl/vue'
export default {
    name: "EditIcon",
    props: ['role'],
    setup() {
        const { can } = useAbility();
        return { can }
    }
}
</script>
