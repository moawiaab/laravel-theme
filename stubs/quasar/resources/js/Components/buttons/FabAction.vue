<template>
    <q-fab-action label-position="left" external-label-position="left">
        <template #label>
            {{ $t(label) }}
        </template>
    </q-fab-action>
</template>
<script setup>
defineProps(["label"]);
</script>
