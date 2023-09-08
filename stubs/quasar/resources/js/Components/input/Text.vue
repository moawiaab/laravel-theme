<script setup>
const props = defineProps([
    "modelValue",
    "type",
    "msg",
    "lazy",
    "error",
    "icon",
]);
const emit = defineEmits(["update:modelValue"]);

function onInput(e) {
    emit("update:modelValue", e.target.value);
}
</script>

<template>
    <q-input
        filled
        borderless
        clearable
        :type="type"
        :lazy-rules="lazy"
        :error="error ? true : false"
        :error-message="error ? error[0] : ''"
    >
        <template #append v-if="icon">
            <q-icon :name="icon" />
        </template>
        <template v-for="(_, slot) of $slots" #[slot]>
            <slot :name="slot" />
        </template>
    </q-input>
</template>

<style lang="scss" scope>
.q-field.row.no-wrap.items-start.q-field--filled.q-input.q-field--labeled.q-field--error.q-field--highlighted.q-field--with-bottom {
    margin-bottom: 5px;
}
</style>
