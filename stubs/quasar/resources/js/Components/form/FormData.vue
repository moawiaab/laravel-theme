<script setup>
import { computed, ref, useSlots } from "vue";

defineEmits(["submitted", "reset", "align"]);

const splitterModel = ref(50);

const props = defineProps({
    btnLabel: { type: String, default: "g.save" },
    loading: { type: Boolean, default: false },
    limits: { type: Array, default: () => [20, 80] },
});
</script>
<template>
    <q-card class="q-px-none" flat>
        <q-form
            @submit="$emit('submitted')"
            @reset="$emit('reset')"
            class="q-gutter-md"
        >
            <q-card-section v-if="$slots.title" class="q-pb-none">
                <slot name="title" />
            </q-card-section>
            <q-separator v-if="$slots.title" class="q-ma-none" />
            <q-card-section class="q-pt-none">
                <q-splitter
                    v-model="splitterModel"
                    :horizontal="$q.platform.is.mobile"
                    style="height: 100%"
                    :limits="limits"
                >
                    <template v-slot:before v-if="$slots.form1">
                        <div class="q-px-sm q-pt-md">
                            <slot name="form1" />
                        </div>
                    </template>

                    <template
                        v-slot:separator
                        v-if="$slots.form1 && $slots.form2"
                    >
                        <q-avatar
                            color="primary"
                            text-color="white"
                            size="20px"
                            icon="drag_indicator"
                        />
                    </template>

                    <template v-slot:after v-if="$slots.form2">
                        <div class="q-px-sm q-pt-md">
                            <slot name="form2" />
                        </div>
                    </template>
                </q-splitter>
                <template v-if="$slots.footer">
                    <q-separator inset />
                    <slot name="footer" />
                </template>
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
.q-card__section.q-card__section--vert.q-pt-none {
    margin-bottom: 0;
    padding-bottom: 0;
}

.remove-marring {
    margin: 0;
}

.q-card__actions.justify-undefined.q-card__actions--horiz.row.text-teal.q-px-sm {
    margin-top: 0;
}
</style>
