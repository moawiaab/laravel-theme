<script lang="ts" setup>
import { ref } from "@vue/runtime-core";

interface Item {
    id: number;
    name: string;
}
const myModel = defineModel();

const props = defineProps({
    msg: { type: String },
    lazy: { type: Boolean, default: true },
    error: { type: String },
    o_id: { type: String, default: "id" },
    o_label: { type: String, default: "name" },
    options: { type: Array<Item> },
    icon: { type: String },
    pIcon: { type: String },
    label: { type: String },
});

const localOptions = ref(props.options);

const filterFn = (val: string, update) => {
    if (val === "") {
        update(() => {
            localOptions.value = props.options;
        });
        return;
    }

    update(() => {
        const needle = val.toLowerCase();
        localOptions.value = props.options!.filter(
            (v) => v.name.toLowerCase().indexOf(needle) > -1
        );
    });
};
</script>

<template>
    <q-select
        v-model="myModel"
        use-input
        filled
        @filter="filterFn"
        input-debounce="0"
        clearable
        :lazy-rules="lazy"
        :error="error ? true : false"
        :error-message="error ? error[0] : ''"
        :option-value="`${o_id}`"
        :option-label="`${o_label}`"
        emit-value
        map-options
        :options="localOptions"
        :label="`${label}`"
    >
        <template v-slot:no-option>
            <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
            </q-item>
        </template>
        <template #prepend v-if="pIcon">
            <q-icon :name="pIcon" />
        </template>
    </q-select>
</template>

<style lang="scss" scope>
.q-field.row.no-wrap.items-start.q-field--filled.q-select.q-field--auto-height.q-select--without-input.q-select--without-chips.q-select--single.q-field--labeled.q-field--error.q-field--highlighted.q-field--with-bottom {
    margin-bottom: 5px;
}
</style>
