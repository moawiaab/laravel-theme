<template>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-icon icon="mdi-database-export-outline" color="blue" class="mx-2" v-bind="props" />

        </template>
        <v-list>
            <v-list-item variant="plain" @click="downloadFile('csv')">
                <template v-slot:prepend>
                    <v-icon icon="mdi-file-document-outline" />
                </template>
                <v-list-item-title > تصدير الى csv </v-list-item-title>
            </v-list-item>
            <v-list-item variant="plain" @click="downloadFile('xlsx')">
                <template v-slot:prepend>
                    <v-icon icon="mdi-file-compare" />
                </template>
                <v-list-item-title > تصدير الى xlsx </v-list-item-title>
            </v-list-item>
            <v-list-item variant="plain"  @click="$htmlToPaper('printMe', null);">
                <template v-slot:prepend>
                    <v-icon icon="mdi-printer-outline" />
                </template>
                <v-list-item-title > طباعة و pdf </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script lang="ts">
import { useSettingsHeaderTable } from '../../stores/settings/SettingHeaderTable'

export default {
    name: 'ExportMenu',
    props: ['url', 'data'],
    setup(props) {
        const item = useSettingsHeaderTable()
        const downloadFile = (type : any) => {
            item.exportFile(props.data, type,props.url)
        }
        return { item, downloadFile }
    }
}
</script>

<style scoped>
.notranslate.v-icon {
    margin-left: 7px !important;
}

.v-list-item__prepend>.v-icon {
    margin-inline-end: 10px !important;
    margin-left: 10px !important;
}

.active-item-aside {
    background-color: #dfd4e9;
    border-radius: 5px !important;
}
</style>
