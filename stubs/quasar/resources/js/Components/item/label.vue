<script lang="ts" setup>
defineProps({
    label: String,
    details: String,
});
</script>

<template>
    <q-item>
        <q-item-label>{{ label }}</q-item-label>
        <q-item-label caption v-if="details">{{ details }}</q-item-label>
    </q-item>
</template>

<style scoped></style>
