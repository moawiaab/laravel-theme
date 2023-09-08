<script lang="ts" setup>
// const myModel = defineModel();
const {
    lazy = true,
    error = "",
    o_id = "id",
    o_label = "name",
} = defineProps<{
    msg: string | null;
    lazy: boolean;
    error: string | null;
    o_id: string | null;
    o_label: string | null;
    options: Array<[]> | null;
    icon: string | null;
}>();
</script>

<template>
    <q-select
        filled
        clearable
        :lazy-rules="lazy"
        :error="error ? true : false"
        :error-message="error ? error[0] : ''"
        :option-value="o_id"
        :option-label="o_label"
        emit-value
        map-options
        :options="options"
    >
        <template #append v-if="icon">
            <q-icon :name="icon" />
        </template>
        <template v-for="(_, slot) of $slots" #[slot]>
            <slot :name="slot" />
        </template>
    </q-select>
</template>

<style lang="scss" scope>
.q-field.row.no-wrap.items-start.q-field--filled.q-select.q-field--auto-height.q-select--without-input.q-select--without-chips.q-select--single.q-field--labeled.q-field--error.q-field--highlighted.q-field--with-bottom {
    margin-bottom: 5px;
}
</style>
