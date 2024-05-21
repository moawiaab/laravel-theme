<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
        :maximized="settings.maximizedToggle"
    >
        <q-card style="min-width: 50vw">
            <widgets-bar />
            <q-card-section>
                <div class="text-h6">{{$t('input.category.title_new')}}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            filled
                            clearable
                            v-model="single.entry.name"
                            :label="$t('input.category.name')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            :error="single.errors.name ? true : false"
                            :error-message="single.errors.name"
                        />

                        <q-input
                            filled
                            c
                            v-model="single.entry.details"
                            :label="$t('g.details')"
                            :rules="[(val) => !!val || $t('v.required')]"
                            type="textarea"
                            :error="single.errors.details ? true : false"
                            :error-message="single.errors.details"
                        />

                        <q-item-label caption class="q-my-xs"
                            >{{$t('g.type')}}
                        </q-item-label>

                        <q-item-label>
                            <q-radio
                                v-model="single.entry.status"
                                checked-icon="task_alt"
                                unchecked-icon="panorama_fish_eye"
                                :val="0"
                                :label="$t('input.category.s0')"
                            />
                        </q-item-label>

                        <q-item-label>
                            <q-radio
                                v-model="single.entry.status"
                                checked-icon="task_alt"
                                unchecked-icon="panorama_fish_eye"
                                :val="1"
                                :label="$t('input.category.s1')"
                            />
                        </q-item-label>
                    </div>
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
import { useCategoriesIndex } from "@/stores/categories/index";
import { useSettings } from "@/stores/settings";
import { useForms } from "@/Composables/Forms";
import { watch } from "vue";
const settings = useSettings();

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useCategoriesIndex();
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

<style></style>
