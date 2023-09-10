<template>
    <v-dialog max-width="1200" v-model="closeModel">
        <template v-slot:activator="{ props }">
            <v-icon icon="mdi-file-import-outline" color="green" v-bind="props" />
        </template>
        <v-card>
            <v-card-title>استيراد بيانات من ملف</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="3">
                        <v-file-input variant="solo" label="اختر الملف المراد تحميله"
                            @change="item.addFile($event)"
                            accept=".ods,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                        <v-list-item-title class="text-red">يجب عن يكون اسم الاعمدة بالانجليزي</v-list-item-title>
                        <v-row v-for="i in localHeader" :key="i">
                            <v-col>{{ i.text }}</v-col>
                            <v-col> = {{ i.value }}</v-col>
                        </v-row>
                    </v-col>
                    <v-divider vertical />
                    <v-col>
                        <data-table :headers="localHeader" :items="item.fileData" :hide-footer="true"
                            :table-height="500" body-text-direction="right" :loading="item.loading" />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn color="blue-darken-1" prepend-icon="mdi-trash-can" variant="tonal" @click="item.fileData = []">
                    تفريغ الجدول
                </v-btn>
                <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal" @click="closeModel = false">
                    إلغاء الأمر
                </v-btn>
                <btn-save :loading="item.loading" @click="storeData" />
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { ref } from 'vue'
import { useSettingsHeaderTable } from '../../stores/settings/SettingHeaderTable'
import { usePageIndex } from '../../stores/pages/pageIndex'

export default {
    name: 'ImportMenu',
    props: ['url', 'title'],
    setup(props) {
        const closeModel = ref(false)
        const item = useSettingsHeaderTable()
        const localHeader = item.headers.filter((e) => e.value != "operation")
        const storeData = () => item.storeData(props.url).then(() => {
            closeModel.value = false;
            usePageIndex().fetchIndexData()
            item.fileData = [];
        })

        return { localHeader, item, closeModel, storeData }
    }
}
</script>
