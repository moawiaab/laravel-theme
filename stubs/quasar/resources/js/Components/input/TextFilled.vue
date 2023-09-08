<template>
  <q-input  clearable class="q-px-sm" input-class="q-px-sm" square hide-bottom-space>
    <template v-for="(_, slot) of $slots" #[slot]>
      <slot :name="slot" />
    </template>
  </q-input>
</template>

<style lang="scss" scoped>
.q-field {
    box-shadow: rgba(0, 0, 0, 0.16) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
    border-radius: 6px;
    margin-bottom: 10px;
}
</style>
