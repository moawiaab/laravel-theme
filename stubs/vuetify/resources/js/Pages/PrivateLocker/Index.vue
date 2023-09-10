<template>
    <main-page :headers="headers" role="store" title="المخازن" :deletable="false" :deleteAll="false" :expand="true"
        :addSelected="false" :editable="false" :createNewItem="false">

        <template #table-operation="{ item }">
            <v-icon icon="mdi-plus-circle-outline" color="indigo" v-if="item.child" @click="showDialog(item)" />
        </template>

        <template #expand="{ item }">
            <v-card>
                <v-card-title class="text-h5 text-primary">اخر خمس تحويلات</v-card-title>
                <v-card-text>
                    <data-table :headers="headersProducts" :items="item.items" body-text-direction="right"
                        :hide-footer="true">
                    </data-table>
                </v-card-text>
            </v-card>
        </template>

        <edit-store />
        <show-store />

        <v-dialog v-model="locker.dialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    ارسال مبلغ الى الخزنة العامة
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-list-item-title>اسم صاحب الخزنة : {{ locker.localData.name }}</v-list-item-title>
                    <v-list-item-title> المبلغ الفعلي : {{ locker.localData.amount }}</v-list-item-title>
                    <v-text-field clearable label="المبلغ المحول" variant="solo" v-model="locker.data.amount"
                        color="primary" />
                    <v-list-item-title> الباقي من التحويلة : {{ locker.localData.amount - locker.data.amount }}
                    </v-list-item-title>
                    <v-text-field clearable label="التفاصيل" variant="solo" v-model="locker.data.details"
                        color="primary" />
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal" @click="locker.dialog = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="locker.loading" @click="locker.sendLocker()" />
                </v-card-actions>
            </v-card>
        </v-dialog>
    </main-page>
</template>

<script lang="ts">
import CreateStore from "./Create.vue";
import EditStore from "./Edit.vue"
import ShowStore from "./Show.vue"
import { usePageIndex } from '../../stores/pages/pageIndex';
import { useUserPrivate } from '../../stores/privateLocker';

export default {
    components: { CreateStore, EditStore, ShowStore },
    name: "IndexStore",
    setup() {
        const pages = usePageIndex();
        const locker = useUserPrivate();
        pages.$reset()
        pages.setup('private-lockers');
        const headers: import('vue3-easy-data-table').Header[] = [
            { text: "صاحب خزنة", value: "name", width: 200, sortable: true },
            { text: "الرصيد الحالي", value: "amount", width: 200, sortable: true },
            { text: "الباقي من اخر تحويل", value: "problem", width: 200 },
            { text: "المبلغ الجديد", value: "on_open" },
            { text: " تاريخ اخر عملية", value: "updated_at", sortable: true },
            { text: "إعدادات", value: "operation", width: 150 },
        ];

        const showDialog = (id: any) => {
            locker.dialog = true;
            locker.setId(id);
        }
        const headersProducts: import('vue3-easy-data-table').Header[] = [
            { text: "جملة المبلغ", value: "on_open"},
            { text: "المبلغ المحول", value: "amount"},
            { text: "الباقي من اخر تحويل", value: "problem"},
            { text: "المرسل", value: "user"},
            { text: "تاريخ الارسال", value: "created_at" },
            { text: "المستلم", value: "admin"},
            { text: "تاريخ الاستلام", value: "updated_at" },
        ];
        return { headers, headersProducts, locker, showDialog }
    }
}
</script>

