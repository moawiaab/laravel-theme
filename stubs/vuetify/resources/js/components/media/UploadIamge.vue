<template>
  <v-card
    rounded="lg"
    class="overflow-hidden"
    width="100%"
    height="400"
    @click.stop="selectImage"
    v-model="items"
  >

    <input
      id="fileInput"
      class="d-none"
      type="file"
      accept="image/*"
      @input="updateValue"
    />
    <v-fade-transition mode="out-in">
      <v-img v-if="image" aspect-ratio="1" :src="image">
            <v-alert
      v-model="alert"
      border="start"
      variant="tonal"
      close-label="نجحت العملية"
      color="deep-purple-accent-4"
      title="Closable Alert"
    >
      تم تحميل الصورة بنجاح اقفل النافذة وقم بتحديث صفحة المنتجات لتظهر لك
      الصورة
    </v-alert>
        <v-row class="fill-height" align="end" justify="center">
          <v-slide-y-reverse-transition>
            <v-sheet
              v-if="mask"
              color="error"
              width="100%"
              height="90%"
              class="mask"
            />
          </v-slide-y-reverse-transition>

          <v-btn
            class="mx-10"
            icon="mdi-delete"
            variant="tonal"
            color="error"
            @click.stop="deleteImage"
            size="large"
          >
          </v-btn>
          <v-spacer />
          <v-progress-circular
            v-if="loading === true"
            :size="100"
            :width="7"
            color="purple"
            indeterminate
          ></v-progress-circular>
        </v-row>
      </v-img>
      <v-row
        v-else
        class="d-flex flex-column align-center justify-center fill-height"
      >
        <v-icon> mdi-paperclip </v-icon>
        <span class="mt-3">Select an Image</span>
      </v-row>
    </v-fade-transition>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      input: undefined,
      image: undefined,
      imageFile: undefined,
      mask: false,
      loading: false,
      alert: false,
    };
  },
  props: ['modelValue', 'id', 'loading'],
  emits: ['update:modelValue'],

  mounted() {
    this.input = document.getElementById("fileInput");
  },
  methods: {
    selectImage() {
      if (!this.imageFile) {
        this.input.click();
      }
    },
    updateValue(event) {
      this.imageFile = event.target.files[0];
      this.image = this.imageFile
        ? URL.createObjectURL(this.imageFile)
        : undefined;
      this.$emit("input", this.imageFile);
      this.$emit("update:modelValue", this.imageFile);
    },
    deleteImage() {
      if (this.imageFile) {
        this.imageFile = undefined;
        this.image = undefined;
        this.mask = false;
        this.input.value = ""; // <-- this will fix the issue
        this.$emit("input", undefined);
        this.$emit("update:modelValue", this.imageFile);
      }
    },
  },
};
</script>

<style scoped>

</style>
