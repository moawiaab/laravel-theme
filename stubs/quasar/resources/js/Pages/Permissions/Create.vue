<template>
    <m-dialog v-model="table.newRow" :title="$t('input.permission.title_new')">
        <one-form
            @submitted="onSubmit"
            @reset="onReset"
            :loading="permission.loading"
        >
            <q-input
                clearable
                filled
                v-model="permission.entry.details"
                :label="$t('input.permission.name')"
                lazy-rules
                :rules="[(val) => !!val || $t('v.required')]"
            />
            <q-input
                clearable
                filled
                v-model="permission.entry.title"
                :label="$t('input.permission.url')"
                lazy-rules
                :rules="[(val) => !!val || $t('v.required')]"
            />

            <div class="row">
                <div class="col">
                    <q-list separator>
                        <q-item>
                            <q-item-label>{{
                                $t("input.permission.name")
                            }}</q-item-label>
                        </q-item>
                        <q-item v-for="i in permission.details" :key="i">
                            {{ i + permission.entry.details }}</q-item
                        >
                    </q-list>
                </div>
                <q-separator vertical />
                <div class="col">
                    <q-list separator>
                        <q-item>
                            <q-item-label>{{
                                $t("input.permission.role")
                            }}</q-item-label>
                        </q-item>
                        <q-item v-for="i in permission.title" :key="i">
                            {{ permission.entry.title + i }}</q-item
                        >
                    </q-list>
                </div>
            </div>
        </one-form>
    </m-dialog>
</template>

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { usePermissionsIndex } from "../../stores/permissions/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const permission = usePermissionsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.newRow) {
                permission.$reset();
                permission.fetchCreateData();
            }
        });

        const onSubmit = () => {
            permission.storeData();
        };

        const onReset = () => {
            permission.entry = {};
        };
        return { table, rules, permission, onSubmit, onReset };
    },
};
</script>

<style></style>
