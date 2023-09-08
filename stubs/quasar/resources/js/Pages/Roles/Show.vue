<template>
    <q-dialog
        v-model="table.showRow"

        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="width: 900px; max-width: 80vw" title="إنشاء مستخدم جديد">
            <q-card-section>
                <div class="text-h6">
                    عرض بيانات المستخدم :
                    {{ table.row.name || user.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter v-model="table.splitterModel" style="height: 100%">
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list>
                                <q-item>
                                    <q-item-label
                                        >اسم المستخدم :
                                        {{ user.entry.name }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        >البريد لالكتروني :
                                        {{ user.entry.email }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        >رقم الهاتف :
                                        {{ user.entry.phone }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        >الفرع :
                                        {{ user.entry.account }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        >الصلاحية :
                                        {{ user.entry.role }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        >تاريخ الانشاء :
                                        {{
                                            user.entry.created_at
                                        }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                            </q-list>
                        </div>
                    </template>

                    <template v-slot:separator>
                        <q-avatar
                            color="primary"
                            text-color="white"
                            size="20px"
                            icon="drag_indicator"
                        />
                    </template>

                    <template v-slot:after>
                        <div class="q-pa-sm">details</div>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    flat
                    label="قفل النافذة"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { useUsersIndex } from "../../stores/users/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const user = useUsersIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.showRow) {
                user.fetchShowData(table.row.id);
            }
        });

        const onSubmit = () => {
            user.storeData();
        };

        const onReset = () => {
            user.entry = {};
        };
        return { table, rules, user, onSubmit, onReset };
    },
};
</script>

<style></style>
