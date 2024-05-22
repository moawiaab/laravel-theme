<script setup>
defineProps(["rows", "columns", "item", "tables"]);
import { useDevelopmentIndex } from "@/stores/development";

const development = useDevelopmentIndex();
</script>
<template>
    <div class="">
        <div class="row" v-if="development.belongsTo">
            <div class="col q-px-sm">
                <q-select
                    filled
                    v-model="development.entry.belongsTo"
                    :options="development.lists.tables"
                    dense
                    emit-value
                    :option-value="`${development.lists.table}`"
                    :option-label="`${development.lists.table}`"
                />
            </div>
            <div class="col q-px-sm">
                <q-input dense clearable filled disable label="id"> </q-input>
            </div>
        </div>
        <q-separator />

        <q-table
            :rows="rows"
            :columns="columns"
            title="Default Field is : | id | user_id | account_id "
            :rows-per-page-options="[]"
            row-key="name"
        >
            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td key="name" :props="props">
                        {{ props.row.name }}
                    </q-td>
                    <q-td key="filed" :props="props">
                        <q-input
                            outlined
                            v-model="props.row.filed"
                            dense
                            autofocus
                        />
                    </q-td>
                    <q-td key="type" :props="props">
                        {{ props.row.type }}
                    </q-td>

                    <q-td key="value" :props="props">
                        {{ props.row.value || "-" }}
                    </q-td>

                    <q-td key="require" :props="props">
                        <q-checkbox v-model="props.row.require" />
                    </q-td>
                </q-tr>
            </template>
        </q-table>
    </div>
</template>
