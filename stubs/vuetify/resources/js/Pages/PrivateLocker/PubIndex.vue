<template>
<div class="">
        <v-row>
        <v-col>
            <v-card variant="tonal" color="info" title="اسم الخزنة">
                <v-list-item append-icon="mdi-alert-decagram-outline" :title="locker.data.pub.name" />
            </v-card>
        </v-col>
        <v-col>
            <v-card variant="tonal" color="success" title="الرصيد الفعلي">
                <v-list-item append-icon="mdi-cash-multiple" :title="locker.data.pub.amount" />
            </v-card>
        </v-col>
        <v-col>
            <v-card variant="tonal" color="error" title="الرصيد المضاف">
                <v-list-item append-icon="mdi-sort-descending" :title="locker.data.pub.add_amount" />
            </v-card>
        </v-col>
        <v-col>
            <v-card variant="tonal" color="primary" title="الرصيد المسحوب">
                <v-list-item append-icon="mdi-sort-ascending" :title="locker.data.pub.take_amount" />
            </v-card>
        </v-col>

    </v-row>
    <main-page :headers="headers" role="public_treasury" title=""  :deleteAll="false" :deletable="false"
        :addSelected="false" :editable="false" :createdItem="false" :viewable="false" :createNewItem="false">

        <template #table-operation="{ item }">
            <v-icon icon="mdi-check-outline" color="info" class="mx-1" v-if="item.status" @click="locker.doneData(item.id)" />
            <delete-icon role="public_treasury" v-if="item.status" @click="showDialog(item.id)" />
        </template>

        <edit-store />
        <show-store />

        <v-dialog v-model="locker.dialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                        لماذا ترفض استلام هذا المبلغ
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                <v-text-field clearable label="سبب الرفض" variant="solo" v-model="locker.entey.details"
                        color="primary" />
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal" @click="locker.dialog = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="locker.loading" @click="sendData" />
                </v-card-actions>
            </v-card>
        </v-dialog>
    </main-page>
</div>
</template>

<script lang="ts">
import CreateStore from "./Create.vue";
import EditStore from "./Edit.vue"
import ShowStore from "./Show.vue"
import { usePageIndex } from '../../stores/pages/pageIndex';
import { usePublicLocker } from '../../stores/privateLocker/pubIndex';
import { useSettingAlert } from '../../stores/settings/SettingAlert';

export default {
    components: { CreateStore, EditStore, ShowStore },
    name: "IndexStore",
    setup() {
        const pages = usePageIndex();
        const locker = usePublicLocker();
        locker.fetchShowData();
        pages.$reset()
        pages.setup('public-treasuries');
        const headers: import('vue3-easy-data-table').Header[] = [
            { text: "صاحب خزنة", value: "name", width: 200},
            { text: "جملة المبلغ", value: "on_open" },
            { text: "المبلغ المحول", value: "amount" },
            { text: "الباقي من اخر تحويل", value: "problem" },
            { text: "المرسل", value: "user.name", sortable: true  },
            { text: "تاريخ الارسال", value: "created_at", sortable: true },
            { text: "المستلم", value: "admin.name", sortable: true  },
            { text: "تاريخ الاستلام", value: "updated_at", sortable: true },
            { text: "إعدادات", value: "operation", width: 150 },
        ];

        const showDialog = (id: any) => {
            locker.dialog = true;
            locker.setId(id);
        }
        const sendData = () => {
            if(locker.entey.details){
                locker.deleteItem()
            }else{
                useSettingAlert().setAlert('ادخل التفاصيل لو سمحت', 'error', true)
            }
        }
        return { headers, locker, showDialog, sendData }
    }
}
</script>

