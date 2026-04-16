<script setup lang="ts">

defineEmits(["submitted", "reset", "align"]);

const props = defineProps({
    btnLabel: {type: String, default: 'g.save'},
    loading: {type: Boolean, default: false},
});
</script>
<template>
    <q-card  flat>
        <q-card-section v-if="$slots.title">
            <div class="text-h6"><slot name="title" /></div>
        </q-card-section>
        <q-separator v-if="$slots.title" />
        <q-form
            @submit="$emit('submitted')"
            @reset="$emit('reset')"
            class=""
        >
            <q-card-section class="q-pt-sm">
               <slot/>
            </q-card-section>
            <q-separator class="remove-marring" />
            <q-card-actions align="right" class="text-teal q-px-sm">
                <q-btn
                    flat
                    :label="$t('g.save')"
                    type="submit"
                    color="primary"
                    class="bg-blue-1"
                    :loading="loading"
                />
                <q-btn
                    :label="$t('g.reset')"
                    type="reset"
                    color="warning"

                    flat
                    class="q-ml-sm bg-yellow-1"
                />
                <q-btn
                    flat
                    :label="$t('g.close')"
                    v-close-popup
                    color="negative"
                    class="bg-red-1"
                />
            </q-card-actions>
        </q-form>
    </q-card>
</template>
<style scoped>

</style>
