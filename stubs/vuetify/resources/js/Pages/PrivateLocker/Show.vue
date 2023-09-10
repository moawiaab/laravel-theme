<template>
    <v-dialog v-model="model.showModalShow" scrollable>
        <v-card>
            <v-card-title class="text-h5 text-primary">
                عرض بيانات المستخدم
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-row>
                    <v-col :cols="settings.window > 1000 ? 3 : 12">
                        <v-list-item>
                            <v-list-item-title>{{ single.entry.name }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-account-outline"> الاسم</v-chip>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>{{ single.entry.email }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-email-outline"> البريد </v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.phone }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-phone-outline"> الهاتف </v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.amount }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-cash"> الرصيد</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.roof }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-cash-100"> السقف</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.address }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-map-marker-outline"> العنوان</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.user }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-account-outline"> المستخدم</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title>{{ single.entry.created_at }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-calendar-range"> تاريخ الانشاء</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item></v-list-item>
                    </v-col>
                    <v-divider vertical v-if="settings.window > 1000" />
                    <v-divider v-else />
                    <v-col :cols="settings.window > 1000 ? 9 : 12">
                        <show-page :data="single.lists.items?.data" :id="single.entry.id"
                            :total="single.lists.items?.total" :headers="headers" />
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
import { watch } from 'vue';
import { useSinglePage } from '../../stores/pages/pageSingle';
import ShowPage from "../../components/pages/Show.vue"
import { useSetting } from '../../stores/settings/SettingIndex';
import { useSinglePrivate } from '../../stores/privateLocker/privateLocker';

export default {
    name: "ShowPrivateLocker",
    components: { ShowPage },
    setup() {
        const single = useSinglePrivate();
        const model = useSinglePage();
        const settings = useSetting();
        watch(model, (e) => {
            if (e.showModalShow)
                single.setupEntry(model.entry, model.lists);
        })
        const headers: import('vue3-easy-data-table').Header[] = [
            { text: "جملة المبلغ", value: "on_open" },
            { text: "المبلغ المحول", value: "amount" },
            { text: "الباقي من اخر تحويل", value: "problem" },
            { text: "المرسل", value: "user.name" },
            { text: "تاريخ الارسال", value: "created_at" },
            { text: "المستلم", value: "admin?.name" },
            { text: "تاريخ الاستلام", value: "updated_at" },
        ];
        return {
            single,
            model,
            headers,
            settings
        }
    },
}
</script>
