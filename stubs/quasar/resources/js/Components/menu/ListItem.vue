<template>
    <q-expansion-item
        group="somegroup"
        icon="explore"
        label="First"
        expand-icon="arrow_drop_down"
        active-class="bg-blue"
        :content-inset-level="0.5"
        expand-separator
        :class="my_class"
        @before-show="my_class = 'active-class'"
        @after-hide="my_class = null"
    >
        <q-list separator>
            <slot />
        </q-list>
    </q-expansion-item>
</template>
<script setup>
import { ref } from "vue";
const my_class = ref();
</script>

<style scoped>
.active-class {
    background: rgb(236, 248, 254);

}
</style>
