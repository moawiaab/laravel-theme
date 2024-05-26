<script setup>
import { useDevelopmentIndex } from "@/stores/development";
import CreateController from "./CreateController.vue";

const development = useDevelopmentIndex();
development.fetchData();
</script>
<template>
    <div>
        <v-btn variant="tonal" class="ma-1" prepend-icon="mdi-pen" @click="development.showModalCreateController = true">
            create new controller</v-btn
        >
        <v-btn variant="tonal" class="ma-1" prepend-icon="mdi-pen">
            create new model</v-btn
        >
        <v-btn variant="tonal" class="ma-1" prepend-icon="mdi-pen">
            create new resources</v-btn
        >
        <v-btn variant="tonal" class="ma-1" prepend-icon="mdi-pen">
            create new requests</v-btn
        >
        <v-expansion-panels variant="accordion">
            <v-expansion-panel title="Controllers that change">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        color="blue"
                        v-for="(item, i) in development.lists.controller_out"
                        :key="i"
                        >{{ item }}</v-chip
                    >
                </template>
            </v-expansion-panel>
            <v-expansion-panel title="Controllers In Vendor">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        color="blue"
                        v-for="(item, i) in development.lists.controller_in"
                        :key="i"
                        >{{ item }}</v-chip
                    >
                </template>
            </v-expansion-panel>
            <v-expansion-panel title="Models that change">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        color="red"
                        v-for="(item, i) in development.lists.models_out"
                        :key="i"
                        >{{ item }}</v-chip
                    >
                </template>
            </v-expansion-panel>
            <v-expansion-panel title="Models In Vendor">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        color="red"
                        v-for="(item, i) in development.lists.models_in"
                        :key="i"
                        >{{ item }}</v-chip
                    >
                </template>
            </v-expansion-panel>
            <v-expansion-panel title="Resources">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        color="green"
                        v-for="(item, i) in development.lists.resources"
                        :key="i"
                        >{{ item }}</v-chip
                    >
                </template>
            </v-expansion-panel>
            <v-expansion-panel title="Requests">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        color="red"
                        v-for="(item, i) in development.lists.requests"
                        :key="i"
                        >{{ item }}</v-chip
                    >
                </template>
            </v-expansion-panel>
            <v-expansion-panel title="Tables">
                <template #text>
                    <v-chip
                        label
                        class="ma-1"
                        v-for="(item, i) in development.lists.tables"
                        :key="i"
                        >{{ item[`${development.lists.table}`] }}</v-chip
                    >
                </template>
            </v-expansion-panel>
        </v-expansion-panels>

        <CreateController/>
    </div>
</template>
