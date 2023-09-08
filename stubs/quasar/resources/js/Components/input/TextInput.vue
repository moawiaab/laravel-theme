<script lang="ts" setup>
const myModel = defineModel();
const { type = "text" } = defineProps<{ type: string; name: string }>();
</script>

<template>
  <q-input filled borderless clearable hide-bottom-space v-model="myModel">
    <template v-for="(_, slot) of $slots" #[slot]>
      <slot :name="slot" />
    </template>
  </q-input>
</template>
