<script lang="ts" setup>
import { ref } from "vue";
import { useProductsIndex } from "@/stores/products/index";
import { useImageUpload } from "@/stores/settings/image";
import CreateProduct from "./create.vue";
import EditProduct from "./edit.vue";
import ViewProduct from "./show.vue";
import MediaImage from "@/Components/media/image.vue"

const imagePath = ref();
const imageShow = ref(false);
const image = useImageUpload();
const product = useProductsIndex();

const showImage = (img: string) => {
    imageShow.value = true;
    imagePath.value = img;
};
</script>

<template>
    <q-page class="">
        <data-table
            :columns="product.columns"
            :title="$t('input.product.title')"
            selection="multiple"
            router="products"
            role="product"
        >
            <template #body-cell-images="props">
                <q-td :items="props.row">
                    <q-avatar
                        size="lg"
                        @click="showImage(props.items.row.photos.url)"
                    >
                        <q-img :src="props.items.row.photos.thumbnail" />
                    </q-avatar>
                    <!-- {{props.items.row.photos}} -->
                </q-td>
            </template>
            <template #options="{ props }">
                <q-btn
                    icon="mdi-image-edit-outline"
                    dense
                    flat
                    glossy
                    rounded
                    color="blue-5"
                    @click="image.setData(props, 'products', 'productPhoto')"
                />
            </template>
        </data-table>

        <create-product />
        <edit-product />
        <!-- <view-product /> -->
        <!-- <media-uploader /> -->
        <media-image />

        <!-- <q-dialog v-model="imageShow">
      <q-img :src="imagePath"/>
    </q-dialog> -->
    </q-page>
</template>

<style scoped></style>
