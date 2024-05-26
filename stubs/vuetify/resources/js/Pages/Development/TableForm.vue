<script setup>
defineProps(["rows", "columns"]);
import { useDevelopmentIndex } from "@/stores/development";

const development = useDevelopmentIndex();
</script>
<template>
    <div class="">
        <v-row v-if="development.belongsTo">
            <v-col class="col q-px-sm">
                <v-select
                    v-model="development.entry.belongsTo"
                    :items="development.lists.tables"
                    dense
                    emit-value
                    :item-title="`${development.lists.table}`"
                    :item-value="`${development.lists.table}`"
                    clearable
                    label="Select Column Type"
                    variant="solo"
                />
            </v-col>
            <v-col class="col q-px-sm">
                <v-text-field variant="solo" color="primary" disable label="id">
                </v-text-field>
            </v-col>
        </v-row>
        <q-separator />

        <v-data-table
            :headers="columns"
            :items="rows"
            item-value="name"
            density="compact"
        >
            <template v-slot:bottom>
                <div class="text-center pt-2">
                    <v-pagination
                        v-model="page"
                        :length="pageCount"
                    ></v-pagination>
                </div>
            </template>
            <template #item.options="{ item }">
               <v-btn icon="mdi-delete" density="compact" color="red" variant="plain" @click="development.deleteItem(item)"/>
            </template>
        </v-data-table>
    </div>
</template>
