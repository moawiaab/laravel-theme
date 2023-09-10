<template>
    <v-row justify="center" dir="rtl">
        <v-dialog v-model="dialog" max-width="800" class="text-right">
            <template v-slot:activator="{ props }">
                <v-avatar
                    variant="plain"
                    class="d-block text-center mx-auto mb-5"
                    icon="mdi-playlist-edit"
                    v-bind="props"
                />
            </template>
            <v-card class="top">
                <v-card-title>إعدادات اختصارات التنقل</v-card-title>
            </v-card>
            <v-card style="height: 300px" color="border-t-0">
                <v-card-text>
                    <splitpanes class="default-theme" rtl style="height: 100%">
                        <pane>
                            <v-list-item title="الإختصارات" />
                            <v-sheet class="px-2">
                                <v-list>
                                    <v-list-item
                                        v-for="(item, index) in items.itemNav"
                                        :key="index"
                                        :title="item.text"
                                        :value="index"
                                        :append-icon="item.icon"
                                        variant="plain"
                                        @click="items.removeItem(index)"
                                    ></v-list-item>
                                </v-list>
                            </v-sheet>
                        </pane>
                        <pane>
                            <v-list-item title="القائمة الجانبية" />
                            <v-sheet class="px-2">
                                <v-list>
                                    <v-list-item
                                        v-for="(item, index) in items.itemSide"
                                        :key="index"
                                        :title="item.text"
                                        :value="index"
                                        :append-icon="item.icon"
                                        variant="plain"
                                        @click="items.addItem(item)"
                                    ></v-list-item>
                                </v-list>
                            </v-sheet>
                        </pane>
                    </splitpanes>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import { useSettingsItem } from "../stores/settings/SettingItem";
import { ref } from "vue";
import { Splitpanes, Pane } from "splitpanes";
export default {
    components: { Splitpanes, Pane },
    setup() {
        const items = useSettingsItem();
        items.setLocalItems();
        const dialog = ref(false);
        return { items, dialog };
    },
};
</script>

<style scoped>
.v-card.v-theme--light.bg-border-t-0.v-card--density-default.v-card--variant-elevated {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.v-card.v-theme--light.top.v-card--density-default.v-card--variant-elevated {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
</style>
