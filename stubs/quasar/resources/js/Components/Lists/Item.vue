<script lang="ts" setup>
import { useQuasar } from "quasar";
defineProps([
  "progress",
  "teacher",
  "tutorials",
  "tutorialCount",
  "url",
  "color",
]);
const $q = useQuasar();

const goToUrl = (id: any) => {
  console.log("🚀 ~ file: Item.vue:5 ~ goToUrl ~ id:", id);
  if (id) {
  } else {
    $q.notify({
      message: "لا يوجد درس لعرضه اذهب الى نافذة المراجعة",
      color: "info",
      icon: "info",
    });
  }
};
</script>

<template>
  <q-item
    clickable
    v-ripple
    @click="goToUrl(url)"
    :to="`${url ? `tutorials/${url}` : ''}`"
  >
    <q-item-section avatar>
      <q-circular-progress
        show-value
        font-size="12px"
        :value="progress"
        size="55px"
        :thickness="0.22"
        :color="color"
        track-color="grey-3"
        class="q-ma-md"
      >
        {{ progress }}%
      </q-circular-progress>
    </q-item-section>

    <q-item-section>
      <q-item-label lines="1"> المدرس : {{ teacher }} </q-item-label>
      <q-item-label caption>
        <q-item-section>
          جميع الدروس : {{ tutorials }} - المتبقية :
          {{ tutorialCount }}
        </q-item-section>
      </q-item-label>
    </q-item-section>

    <q-item-section side>
      <q-icon v-if="tutorialCount == 0" name="done_all" color="info" />
      <q-icon v-else name="link" color="red" />
    </q-item-section>
  </q-item>
</template>

<style scoped></style>
