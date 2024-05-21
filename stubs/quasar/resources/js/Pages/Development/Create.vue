<script setup>
import { useDevelopmentCreate } from "@/stores/development/create";

const development = useDevelopmentCreate();
development.fetchData();
</script>
<template>
    <q-page padding>
        <div class="row justify-start">
            <div class="col-4" v-for="(item, i) in development.lists" :key="i">
                <q-card class="q-ma-sm" :class="item.type ? 'bg-green-1' : ''">
                    <q-card-section>
                        <div class="text-h6">{{ item.name }}</div>
                        Adding
                        <span class="text-primary">{{ item.name }}</span>
                        library to the program
                    </q-card-section>

                    <q-card-section>
                        Special files are created for the library, such as
                        control, table, and links
                    </q-card-section>
                    <q-separator />
                    <q-card-actions>
                        <q-btn flat v-if="item.type" color="red" icon="delete"
                            @click="development.removeItem(item.name, 'remove')">Uninstall</q-btn
                        >
                        <q-btn flat v-else color="green" icon="edit"
                        @click="development.removeItem(item.name, 'add')">Install</q-btn
                        >
                    </q-card-actions>
                </q-card>
            </div>
        </div>
    </q-page>
</template>
