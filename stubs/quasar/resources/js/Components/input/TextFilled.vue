<script lang="ts" setup>
const myModel = defineModel();
defineProps({
    msg: { type: String },
    lazy: { type: Boolean, default: true },
    error: { type: String },
    o_id: { type: String, default: "id" },
    o_label: { type: String, default: "name" },
    icon: { type: String },
    pIcon: { type: String },
    label: { type: String },
    type: { type: String, default: "text" },
});
</script>
<template>
    <q-input
        v-model="myModel"
        filled
        clearable
        :lazy-rules="lazy"
        :error="error ? true : false"
        :error-message="error ? error[0] : ''"
        :label="`${label}`"
        :type="`${type}`"
    >
        <template #append v-if="icon">
            <q-icon :name="icon" />
        </template>
        <template #prepend v-if="pIcon">
            <q-icon :name="pIcon" />
        </template>
    </q-input>
</template>
