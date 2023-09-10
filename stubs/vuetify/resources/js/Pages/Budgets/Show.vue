<template>
    <v-dialog v-model="model.showModalShow" max-width="1200">
        <v-card>
            <v-card-title class="text-h5 text-primary">
                عرض بيانات المستخدم
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-row>
                    <v-col cols="4">
                        <v-list-item>
                            <v-list-item-title>{{ single.entry.name }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-account-outline"> اسم القسم</v-chip>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>{{ single.entry.details }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-email-outline"> تفاصيل القسم </v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.status }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-phone-outline"> حالة المنتج </v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.created_at }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-lock-outline"> تاريخ الانشاء</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item></v-list-item>
                    </v-col>
                    <v-divider vertical />
                    <v-col scrollable>
                        <data-table :headers="headersProducts" :items="single.lists?.products"  v-if="single.lists?.products"/>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider />
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                    @click="model.showModalShow = false">
                    إلغاء الأمر
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script lang="ts">
import { useSinglePage } from '../../stores/pages/pageSingle';
import { useSingleCategories } from '../../stores/Categories/single';
import { watch } from '@vue/runtime-core';

export default {
    name: "ShowExpanse",
    setup() {
        const single = useSingleCategories();
        const model = useSinglePage();
        watch(model, (e) => {
            if (e.showModalShow)
                single.setupEntry(model.entry, model.lists)
        })

        const headersProducts: import('vue3-easy-data-table').Header[] = [
            { text: "اسم المنتج", value: "name", width: 200, sortable: true },
            { text: "التفاصيل", value: "details", width: 200, sortable: true },
            { text: "قسم المنتج", value: "category", width: 200 },
            { text: "تاريخ الإنشاء", value: "created_at", sortable: true },
            // { text: "", value: "operation", width: 100 },
        ];
        return {
            single,
            model,
            headersProducts
        }
    },
}
</script>
