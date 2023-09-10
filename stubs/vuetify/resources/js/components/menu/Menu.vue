<template>
    <v-list class="">
        <template v-for="(item, index) in sidebar.items">
            <v-list-group
                v-if="item.children && can(`${item.access}_access`, 'all')"
                :key="index"
                :value="index"
                active-color="primary"
                :fluid="true"
            >
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        :title="item.text"
                        :prepend-icon="item.icon"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="(i, id) in item.children"
                    :key="id"
                    :value="i.text"
                    :title="i.text"
                    :prepend-icon="i.icon"
                    :to="i.url"
                    active-color="primary"
                ></v-list-item>
            </v-list-group>
            <template v-else>
                <v-list-item
                    :prepend-icon="item.icon"
                    :title="item.text"
                    :key="item.url"
                    :to="item.url"
                    active-color="primary"
                    v-if="can(`${item.access}_access`, 'all')"
                ></v-list-item>
            </template>
        </template>
    </v-list>
</template>

<script lang="ts">
import { useSettingsItem } from "../../stores/settings/SettingItem";
import MenuItem from "./MenuItem.vue";
import { useAbility } from "@casl/vue";

export default {
    name: "recursive-menu",
    components: {
        MenuItem,
    },
    setup() {
        const { can } = useAbility();
        const sidebar = useSettingsItem();
        return { sidebar, can };
    },
};
</script>

<style lang="scss">
.v-list-item__prepend {
    .v-icon {
        margin-inline-end: 10px !important;
        // margin-left: 10px !important;
    }
}
</style>
