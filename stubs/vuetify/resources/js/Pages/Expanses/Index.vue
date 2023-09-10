<template>
    <main-page :headers="headers" role="expanse" title="الموازنة المالية" :deletable="false" :deleteAll="false"
        :addSelected="false" :viewable="false" :expand="true">
        <template #create>
            <create-expanse />
        </template>

        <template #table-operation="{ item }">
            <v-icon icon="mdi-plus-circle-outline" color="indigo" v-if="item.status" @click="showDialog(item.id)" />
            <toggle-icon @click="pages.toggleItem(item.id)" role="category" :toggle="item.status" />
        </template>


        <template #expand="{ item }">
            <v-card>
                <v-card-title class="text-h5 text-primary"
                    >اخر خمس تحويلات</v-card-title
                >
                <v-card-text>
                    <data-table
                        :headers="headersItems"
                        :items="item.items"
                        body-text-direction="right"
                        :hide-footer="true"
                    >
                    </data-table>
                </v-card-text>
            </v-card>
        </template>

        <edit-expanse />
        <show-expanse />

        <v-dialog v-model="expanse.dialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    فتح خزنة لهذا المستخدم
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field clearable label="المبلغ" variant="solo" hint="المبلغ المراد سحبه"
                        v-model="expanse.data.amount" color="primary" />
                    <v-text-field clearable label=" التفاصيل" variant="solo" hint=" تفاصيل الصرفة"
                        v-model="expanse.data.details" color="primary" />
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                        @click="expanse.dialog = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="expanse.loading" @click="sendAmount" />
                </v-card-actions>
            </v-card>
        </v-dialog>

    </main-page>
</template>

<script lang="ts">
import CreateExpanse from "./Create.vue";
import EditExpanse from "./Edit.vue"
import ShowExpanse from "./Show.vue"
import { usePageIndex } from '../../stores/pages/pageIndex';
import { useExpansesIndex } from "../../stores/expanses/expanse";
import { useSettingAlert } from '../../stores/settings/SettingAlert';

export default {
    components: { CreateExpanse, EditExpanse, ShowExpanse },
    name: "IndexExpanse",
    setup() {
        const pages = usePageIndex();
        const expanse = useExpansesIndex()
        const showDialog = (id: Number) => {
            expanse.dialog = true;
            expanse.setId(id);
        }
        pages.$reset()
        pages.setup('expanses');
        const headers: import('vue3-easy-data-table').Header[] = [
            { text: " السنة المالية", value: "stage", width: 200, sortable: true },
            { text: "اسم المصروف", value: "name", width: 200, sortable: true },
            { text: "المبلغ المحدد", value: "amount" },
            { text: "المبلغ المصروف", value: "expanses" },
            { text: "المبلغ المتبقي", value: "new_amount" },
            { text: "عدد المعاملات", value: "num" },
            { text: "تاريخ الإنشاء", value: "created_at", sortable: true },
            { text: "إعدادات", value: "operation", width: 150 },
        ];

                    const headersItems: import('vue3-easy-data-table').Header[] = [
            { text: " المبلغ", value: "amount"},
            { text: "التفاصيل", value: "details"},
            { text: "المرسل", value: "user"},
            { text: "تاريخ الارسال", value: "created_at" },
        ];
        const sendAmount = () => {
            if (validation()) {
                expanse.sendAmount()
            }else{
                useSettingAlert().setAlert('لا تترك حقلا فارغا لو سمحت', 'error', true)
            }
        }

        const validation = () => {
            return (expanse.data.details && expanse.data.amount)
        }
        return { headers, pages, expanse, showDialog, sendAmount,headersItems }
    }
}
</script>

