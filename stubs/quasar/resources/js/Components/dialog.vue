<script setup lang="ts">
import { UseDraggable as Draggable } from "@vueuse/components";
import { isClient } from "@vueuse/core";
import { shallowRef, useTemplateRef } from "vue";
import { useSettings } from "@/stores/settings";
// import { Expanse } from "@/types";
const settings = useSettings();
const handle = useTemplateRef("handle");
const innerWidth = isClient ? window.innerWidth : 250;
// const disabled = shallowRef(false);
const myModel = defineModel<boolean>();

const disabled = shallowRef(false);

defineProps({
    title: { type: String, default: "title" },
    icon: { type: String, default: "edit" },
    w: { type: Number, default: 50 },
    mh: { type: Number, default: 200 },
});
</script>
<template>
    <q-dialog
        v-model="myModel"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile ? true : settings.maximizedToggle"
    >
        <Draggable
            p="x-4 y-2"
            shadow="~ hover:lg"
            class="fixed select-none w100%"
            :initial-value="{ x: innerWidth / 3.6, y: mh }"
            :prevent-default="true"
            :handle="handle"
            :disabled="disabled"
        >
            <div
                class="main-dialog bg-white dark:bg-gray-800 rounded-b-lg"
                :style="{
                    minHeight: mh + 'px',
                    minWidth: w + 'vw',
                    height : $q.platform.is.mobile || settings.maximizedToggle ? '100vh' : 'auto',
                    maxWidth: '100vw',
                    width : $q.platform.is.mobile || settings.maximizedToggle ? '100vw' : w + 'vw',
                }"
            >
                <div ref="handle" class="cursor-move">
                    <widgets-bar :title="title" :icon="icon" />
                </div>
                <slot />
            </div>
        </Draggable>
    </q-dialog>
</template>

<style scoped>
@media (min-width: 600px) {
    .q-dialog__inner--minimized > div {
        max-width: none !important;
        max-height: 100% !important;
    }
}
.cursor-move {
  cursor: move;
}
</style>
