<template>
    <q-fab
        color="primary"
        vertical-actions-align="right"
        glossy
        icon="keyboard_arrow_up"
        direction="up"
        v-model="fabLeft"
    >
        <fab v-for="(item, index) in data" :key="index" v-bind="item" :label="item.label" />
    </q-fab>
</template>
<script setup>
import { ref } from "vue";
import fab from "./FabAction.vue";
defineProps(["data"]);

const fabLeft = ref();
</script>
