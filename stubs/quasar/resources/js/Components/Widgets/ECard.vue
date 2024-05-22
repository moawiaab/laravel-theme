<script setup>
defineProps(['label','icon'])
</script>
<template>
    <q-expansion-item
        expand-separator
        :label="label"
    >
    <template #icon>

    </template>
        <q-card>
            <q-card-section>
                <slot />
            </q-card-section>
        </q-card>
    </q-expansion-item>
</template>
