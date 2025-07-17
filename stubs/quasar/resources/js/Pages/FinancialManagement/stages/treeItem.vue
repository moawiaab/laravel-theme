<script setup>
import {ref} from "vue"
defineProps(["stages"]);
const expanded = ref();
</script>

<template>
    <q-tree :nodes="stages"  node-key="id" v-if="stages" >

    </q-tree>
</template>

<style scoped></style>
