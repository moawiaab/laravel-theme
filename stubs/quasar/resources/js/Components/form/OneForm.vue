<script setup>
defineEmits(["submitted", "reset"]);
</script>
<template>
    <q-card class="q-px-sm" flat>
        <q-card-section>
            <div class="text-h6"><slot name="title" /></div>
        </q-card-section>
        <q-form
            @submit="$emit('submitted')"
            @reset="$emit('reset')"
            class="q-gutter-md"
        >
            <q-card-section class="q-pt-none">
                <slot></slot>
            </q-card-section>
            <!-- <q-separator /> -->
            <q-card-actions align="" class="text-teal q-px-sm">
                <slot name="actions" />
            </q-card-actions>
            <q-separator />
        </q-form>
    </q-card>
</template>
