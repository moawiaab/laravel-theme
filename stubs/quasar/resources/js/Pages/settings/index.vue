<script lang="ts" setup>
import { useSettingsSide } from "@/stores/settings/index";
import { ref, onMounted } from "vue";

const setting = useSettingsSide();

onMounted(() => {
    setting.fetchGetData();
});

const splitterModel = ref(50);
const onSubmit = () => {
    setting.setSetting();
};
</script>

<template>
    <q-page v-if="setting.entry">
        <q-form @submit="onSubmit">
            <q-card class="my-card" flat>
                <q-card-section>
                    <div class="text-h6">إعدادات النظام</div>
                </q-card-section>

                <q-splitter
                    v-model="splitterModel"
                    :style="`height : ${$q.screen.height - 200}px`"
                >
                    <template v-slot:before>
                        <div class="q-pa-md">
                            <q-list dense separator>
                                <q-item dense>
                                    <q-item-section>
                                        <q-item-label>
                                            ضبط المصروفات</q-item-label
                                        >
                                        <q-item-label caption>
                                            <q-toggle
                                                v-model="setting.entry.exp_roof"
                                                label="إضافة مصروف بعد تجاوز حد الموازنة المسموح بها"
                                                size="lg"
                                            />
                                            <q-toggle
                                                v-model="setting.entry.exp_conf"
                                                label="خصم مبلغ المصروف من الخزنة الشخصية بعد عملية التأكيد"
                                                size="lg"
                                            />
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>

                                <q-item dense>
                                    <q-item-section>
                                        <q-item-label>
                                            ضبط الفواتير</q-item-label
                                        >
                                        <q-item-label caption>
                                            <q-toggle
                                                v-model="
                                                    setting.entry.order_sup_conf
                                                "
                                                label="إضافة الكمية الى المخزن بعد عملية التأكيد في نافذة المشتريات"
                                                size="lg"
                                            />
                                            <q-toggle
                                                v-model="
                                                    setting.entry.order_conf
                                                "
                                                label="خصم الكمية من المخزن بعد عملية التأكيد في فواتير المبيعات"
                                                size="lg"
                                            />
                                            <q-toggle
                                                v-model="
                                                    setting.entry
                                                        .order_back_conf
                                                "
                                                label="إضافة الكمية المرتجع الى المخزن بعد عملية التأكيد في نافذة المرتجعات"
                                                size="lg"
                                            />
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item dense>
                                    <q-item-section>
                                        <q-item-label>
                                            ضبط الخزائن المالية</q-item-label
                                        >
                                        <q-item-label caption>
                                            <q-toggle
                                                v-model="
                                                    setting.entry.locker_conf
                                                "
                                                label="فتح الخزنة الشخصية افتراضيا للمستخدم الجديد"
                                                size="lg"
                                            />
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
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
                        <div class="q-pa-md">
                            <!-- <pre>{{ setting.entry }}</pre> -->
                        </div>
                    </template>
                </q-splitter>
                <q-separator />

                <q-card-actions align="right">
                    <q-btn color="primary" glossy type="submit"
                        >حفظ التغييرات</q-btn
                    >
                </q-card-actions>
            </q-card>
        </q-form>
    </q-page>
</template>

<style scoped></style>
