<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="$q.platform.is.mobile? true: settings.maximizedToggle"
    >
        <q-card style="min-width: 60vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{ $t("input.user.title_new") }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <q-splitter
                        v-model="table.splitterModel"
                        style="height: 100%"
                    >
                        <template v-slot:before>
                            <div class="q-pa-sm">inputsItem</div>
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
                            <div class="q-pa-sm">Set Details Her</div>
                        </template>
                    </q-splitter>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        :label="$t('g.save')"
                        type="submit"
                        color="primary"
                        :loading="single.loading"
                    />
                    <q-btn
                        :label="$t('g.reset')"
                        type="reset"
                        color="warning"
                        flat
                        class="q-ml-sm"
                    />
                    <q-btn
                        flat
                        :label="$t('g.close')"
                        v-close-popup
                        color="negative"
                    />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useForms } from "@/Composables/rules";
import { useUsersIndex } from "@/stores/users/index";
import { watch } from "@vue/runtime-core";
import { useSettings } from "@/stores/settings";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useUsersIndex();

watch(table, (e) => {
    if (e.newRow) {
        single.$reset();
        single.fetchCreateData();
    }
});

const onSubmit = () => {
    single.storeData();
};

const onReset = () => {
    single.entry = {};
};
</script>
