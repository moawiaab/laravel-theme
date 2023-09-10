<template>
    <main-page :headers="headers" role="user" title="المستخدمين">
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-user v-if="model.showModalCreate" />
        </template>

        <template #table-operation="{ item }">
            <v-icon
                icon="mdi-plus-circle-outline"
                color="indigo"
                v-if="!item.locker && can('private_locker_create', 'all')"
                @click="showDialog(item.id)"
            />
            <toggle-icon
                @click="pages.toggleItem(item.id)"
                role="category"
                :toggle="item.status"
                v-if="can('user_edit', 'all')"
            />
        </template>

        <template #item-phone="{item}">
            {{item.id}}
        </template>

        <edit-user />
        <show-user />
        <v-dialog v-model="user.dialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    فتح خزنة لهذا المستخدم
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field
                        clearable
                        label="الرصيد الافتتاحي"
                        variant="solo"
                        hint="المبلغ الفعلي في خزنة المستخدم"
                        v-model="user.data.amount"
                        color="primary"
                    />
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="user.dialog = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                    <btn-save
                        :loading="user.loading"
                        @click="user.sendLocker()"
                    />
                </v-card-actions>
            </v-card>
        </v-dialog>
    </main-page>
</template>

<script lang="ts" setup>
import Image from "../../components/media/UploadIamge.vue";
import CreateUser from "./Create.vue";
import EditUser from "./Edit.vue";
import ShowUser from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { useUserIndex } from "../../stores/users/users";
import { ref } from "vue";
import axios from "axios";
import { useAbility } from "@casl/vue";

const { can } = useAbility();
// const myId = ref<Number | null | String>(null);
// const loading = ref(false);
// const files = ref();
// const showModel = ref(false);

const user = useUserIndex();
const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("users");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم المستخدم", value: "name", width: 200, sortable: true },
    { text: "البريد", value: "email", width: 200 },
    { text: "رقم الهاتف", value: "phone", sortable: true },
    { text: "الصلاحية", value: "role", sortable: true },
    { text: "الفرع", value: "account" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation", width: 150 },
];

const showDialog = (id: number) => {
    user.dialog = true;
    user.setId(id);
};

// const showPhote = (id: Number) => {
//     showModel.value = !showModel.value;
//     myId.value = id;
// };
// const uploadImage = () => {
//     return new Promise(async (resolve, reject) => {
//         loading.value = true;
//         const formData = new FormData();
//         formData.append("id", myId.value);
//         formData.append("file", files.value);
//         formData.append("model_id", myId.value);
//         formData.append("collection_name", "userPhoto");
//         await axios
//             .post(`/users/media`, formData, {
//                 headers: {
//                     "Content-Type": "multipart/form-data",
//                 },
//             })
//             .then((response) => {
//                 // alert.value = true;
//                 pages.fetchIndexData();
//                 showModel.value = false;
//             });
//         loading.value = false;
//     });
// };
</script>
