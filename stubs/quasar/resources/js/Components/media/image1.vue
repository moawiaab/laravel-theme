<script lang="ts" setup>
import { ref } from "vue";
import { useImageUpload } from "@/stores/settings/image";
const image = useImageUpload();
</script>

<template>
    <q-dialog
        v-model="image.dialog"
        transition-show="scale"
        transition-hide="scale"
    >
        <q-uploader
            url="products/media"
            style="max-width: 300px"
        />
        <!-- <q-card style="min-width: 50vw">

        </q-card> -->
    </q-dialog>
</template>

<style scoped></style>
