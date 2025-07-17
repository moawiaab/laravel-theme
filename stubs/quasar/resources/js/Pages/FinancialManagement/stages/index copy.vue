<script lang="ts" setup>
import { ref, onMounted } from "vue";

import axios from "axios";
const stages = ref(null);
const expanded = ref();
onMounted(async () => {
    const { data } = await axios.get("stages");
    stages.value = data;
});
</script>

<template>
    <q-page padding>
        <q-tree :nodes="stages" accordion node-key="id" v-if="stages">
            <template v-slot:default-body="prop">
                <div class="d" v-if="prop.node.amount || prop.node.expense">
                    <q-chip
                        dense
                        color="green-2"
                        text-color="green"
                        :label="`المبلغ المصدق : ${prop.node.amount || 0}`"
                        square
                    />
                    <q-chip
                        dense
                        color="red-2"
                        text-color="red"
                        :label="`المبلغ المصروف : ${prop.node.expense || 0}`"
                        square
                    />
                    <q-chip
                        dense
                        color="red-2"
                        text-color="red"
                        icon="arrow_left"
                        square
                    />
                    <q-chip
                        dense
                        color="info-2"
                        text-color="info"
                        :label="` الباقي من الموازنة : ${
                            prop.node.amount - prop.node.expense
                        }`"
                        square
                    />
                </div>

                <div
                    class="d"
                    v-if="prop.node.start_date || prop.node.end_date"
                >
                    <q-chip
                        dense
                        color="blue-1"
                        text-color="blue"
                        :label="` بداية السنة المالية : ${
                            prop.node.start_date || 0
                        }`"
                        square
                    />
                    <q-chip
                        dense
                        color="blue-1"
                        text-color="blue"
                        :label="` نهاية السنة المالية : ${prop.node.end_date}`"
                        square
                    />
                </div>
                <div
                    v-if="prop.node.details"
                    v-html="`التفاصيل : ${prop.node.details}`"
                ></div>
            </template>
        </q-tree>
    </q-page>
</template>

<style scoped></style>
