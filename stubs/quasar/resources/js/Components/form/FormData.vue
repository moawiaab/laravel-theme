<script setup>
import { computed, ref, useSlots } from "vue";

defineEmits(["submitted", "reset"]);

const splitterModel = ref(50);
const { hasActions, title } = computed(() => !!useSlots().actions);
</script>
<template>
  <q-card class="q-px-sm" flat>
    <q-card-section v-if="title">
      <div class="text-h6"><slot name="title" /></div>
    </q-card-section>
    <q-separator v-if="title" />
    <q-form
      @submit="$emit('submitted')"
      @reset="$emit('reset')"
      class="q-gutter-md"
    >
      <q-card-section class="q-pt-none">
        <q-splitter v-model="splitterModel" style="height: 100%">
          <template v-slot:before>
            <div class="q-px-sm q-pt-md">
              <slot name="form1" />
            </div>
          </template>

          <template v-slot:separator>
            <q-avatar
              color="primary"
              text-color="white"
              size="20px"
              icon="drag_indicator"
            />
          </template>

          <template v-slot:after>
            <div class="q-px-sm q-pt-md">
              <slot name="form2" />
            </div>
          </template>
        </q-splitter>
      </q-card-section>
      <q-separator class="remove-marring" />
      <q-card-actions v-if="hasActions" align="" class="text-teal q-px-sm">
        <slot name="actions" />
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
