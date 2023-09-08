<template>
    <q-item clickable :class="`${color ? `bg-${color}-1 text-${color}` : ''}`">
        <q-item-section>
            {{ $t(text) }}
        </q-item-section>
        <q-item-section side>
            <q-icon :name="icon || 'explore'" />
        </q-item-section>
    </q-item>
</template>

<script setup>
defineProps({ text: String, icon: String, color: String });
</script>

<style></style>
