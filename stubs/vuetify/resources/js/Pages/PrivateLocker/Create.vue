<template>
    <v-btn variant="text" @click="model.showModalCreate = true"> إضافة منتج</v-btn>
    <v-dialog v-model="model.showModalCreate" persistent max-width="600" scrollable>
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة منتج جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field clearable label="اسم المنتج" variant="solo" hint="هنا اسم المنتج "
                        v-model="single.entry.name" :rules="rules.required" :error-messages="single.errors.name"
                        required color="primary" />
                    <v-text-field clearable label="التفاصيل" variant="solo" hint="هنا التفاصيل المنتج "
                        v-model="single.entry.details" :rules="rules.required" :error-messages="single.errors.details"
                        required color="primary" />

                    <v-autocomplete v-model="single.entry.products" :items="single.lists.products" clearable
                        variant="solo" chips closable-chips color="blue-grey-lighten-2" label="المنتجات"
                        item-title="name" item-value="id" multiple>
                        <template v-slot:chip="{ props, item }">
                            <v-chip v-bind="props" :text="item.raw.name"></v-chip>
                        </template>
                        <template v-slot:item="{ props, item }">
                            <v-list-item v-if="typeof item.raw !== 'object'" v-bind="props"></v-list-item>
                            <v-list-item v-else v-bind="props" :title="item.raw.name">
                            </v-list-item>
                        </template>
                    </v-autocomplete>



                </v-card-text>

                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                        @click="model.showModalCreate = false">
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts">
import { useSingleStores } from '../../stores/Stores/single';
import { useSettingAlert } from '../../stores/settings/SettingAlert';
import { useSinglePage } from '../../stores/pages/pageSingle';
import { watch } from 'vue';

export default {
    name: "CreateStore",
    setup() {
        const single = useSingleStores();
        const model = useSinglePage();
        watch(model, (e) => {
            if (e.showModalCreate) {
                single.$reset();
                single.setupEntry(model.entry, model.lists)
            }
        })

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => {
            if (validation()) {
                single.storeData().then(() => {
                    single.$reset;
                    model.showModalCreate = false;
                    model.entry = {}
                })
            } else {
                useSettingAlert().setAlert("لا تترك حقل فارغ لو سمحت", 'warning', true)
            }
        }
        const validation = () => {
            return (single.entry.name && single.entry.details)
        }
        return {
            model,
            single,
            rules,
            submitForm,
        }
    },

}
</script>
