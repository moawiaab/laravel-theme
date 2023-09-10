<template>
    <v-icon
        :icon="
            toggle
                ? 'mdi-toggle-switch-outline'
                : 'mdi-toggle-switch-off-outline'
        "
        :color="toggle ? 'primary' : 'warning'"
        class="mx-1"
        v-if="can(`${role}_edit`, 'all')"
        size="24"
    />
</template>

<script lang="ts">
import { useAbility } from "@casl/vue";

export default {
    name: "ToggleIcon",
    props: {
        toggle: { type: Boolean, default: false },
        role: { type: String, default: "none" },
    },
    setup() {
        const { can } = useAbility();
        return { can };
    },
};
</script>
