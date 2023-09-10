<template>
    <v-icon icon="mdi-eye-settings-outline" color="blue" class="mx-1" v-if="can(`${role}_access`,  'all')" />
</template>

<script lang="ts">
import { useAbility } from '@casl/vue'
export default {
    name: "ShowIcon",
    props: ['role'],
    setup() {
        const { can } = useAbility();
        return { can }
    }
}
</script>
