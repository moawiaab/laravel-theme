<script lang="ts" setup>
import { ref } from "vue";
import { useImageUpload } from "@/stores/settings/image";
const image = useImageUpload();

const imageFile = ref(null);
const imagePath = ref();
const selectImage = () => {
    if (!image.loading) {
        document.getElementById("inputImage")?.click();
    }
};

const updateValue = (e: any) => {
    image.file = e.target.files[0];
    imagePath.value = image.file ? URL.createObjectURL(image.file) : undefined;
};
</script>

<template>
    <q-dialog
        v-model="image.dialog"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="min-width: 50vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">تحميل الصورة الى السيرفر</div>
            </q-card-section>
            <q-separator />
            <!-- <q-form @submit="onSubmit" class="q-gutter-md"> -->
            <q-card-section class="q-pt-none">
                <input
                    type="file"
                    accept="image/*"
                    id="inputImage"
                    @input="updateValue"
                    hidden
                />
                <div class="q-pa-sm">
                    <q-img :src="imagePath" @click="selectImage()">
                        <div
                            class="absolute-full text-subtitle1 flex flex-center"
                            v-if="!imagePath"
                        >
                            أضغط كلك لتحميل الصورة
                        </div>
                        <div class="absolute-bottom text-center" v-else>
                            لتغيير الصورة اضغط كلك في الصورة
                        </div>

                        <div
                            class="absolute-full text-subtitle1 flex flex-center"
                            v-if="imagePath && image.loading"
                        >
                            <q-item-section class="text-center">
                                <q-item-label>
                                    <q-spinner-box color="white" size="100px" />
                                </q-item-label>
                                <q-item-label>
                                    جار تحميل الصورة الى السيرفر
                                    <q-spinner-dots
                                        color="white"
                                        size="25"
                                        class="q-mx-sm"
                                    />
                                </q-item-label>
                            </q-item-section>
                        </div>
                    </q-img>
                </div>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    v-if="imagePath"
                    flat
                    label=" تحميل الصورة "
                    color="primary"
                    :loading="image.loading"
                    @click.stop="image.uploadImage()"
                />
                <q-btn
                    flat
                    label="قفل النافذة"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
            <!-- </q-form> -->
        </q-card>
    </q-dialog>
</template>

<style scoped></style>
