<template>
    <q-dialog
        v-model="table.showRow"

        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="width: 900px; max-width: 80vw" title="إنشاء مستخدم جديد">
            <q-card-section>
                <div class="text-h6">
                    {{ $t("input.user.view") }} :
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
                                        >{{$t('input.user.name')}} :
                                        {{ user.entry.name }}</q-item-label
                                    >
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
                        <div class="q-pa-sm">details</div>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    flat
                    :label="$t('g.close')"
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
