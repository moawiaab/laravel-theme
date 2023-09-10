<template>
    <div class="menu-item" :class="{ opened: expanded || openUrl.includes(route.path) }"
        v-if="can(`${access}_access`,'all')">
        <v-list-item @click="toggleMenu()" v-if="data" :active="expanded || openUrl.includes(route.path)">
            <template v-slot:prepend>
                <v-icon :icon="icon"></v-icon>
            </template>
            <v-list-item-title v-text="label"> </v-list-item-title>
            <template v-slot:append>
                <v-icon :icon="`${expanded || openUrl.includes(route.path)
                ? 'mdi-chevron-down'
                : 'mdi-chevron-left'
                }`" :class="{ opened: expanded }">
                </v-icon>
            </template>
        </v-list-item>

        <!-- <router-link :to="url" v-else> -->
            <v-list-item :title="label"  :to="url" v-else>
                <template v-slot:prepend>
                    <v-icon :icon="icon"></v-icon>
                </template>
            </v-list-item>
        <!-- </router-link> -->

        <v-divider></v-divider>
        <div v-show="showChildren || openUrl.includes(route.path)" class="items-container" :style="{
            height: openUrl.includes(route.path) ? '100%' : containerHeight,
            background: settings.theme == 'light' ? '#eeeeee' : '#424242'
        }" ref="container">
            <menu-item :class="{ opened: showChildren }" v-for="(item, index) in data" :key="index"
                :data="item.children" :label="item.text" :icon="item.icon" :depth="depth + 1" :url="item.url"
                :access="item.access" />
        </div>
    </div>
</template>

<script>
import { ref, onMounted, nextTick, onUnmounted, watch } from "vue";
import { useRoute } from "vue-router";
import { useSetting } from "../../stores/settings/SettingIndex";
import { useAbility } from "@casl/vue";
export default {
    name: "menu-item",
    props: {
        data: { type: Object },
        label: { type: String },
        icon: { type: String },
        access: { type: String },
        depth: { type: Number },
        smallMenu: { type: Boolean },
        url: { type: String },
        openUrl: { type: Array, default: [] },
    },
    setup(props) {
        const { can } = useAbility()
        const expanded = ref(false);
        const showChildren = ref(false);
        const containerHeight = ref(0);
        const container = ref(null);
        const itemToggleMenu = ref(false);
        const settings = useSetting();
        const toggleMenu = () => {
            expanded.value = !expanded.value;
            if (!showChildren.value) {
                showChildren.value = true;
                nextTick(() => {
                    containerHeight.value = container.value.scrollHeight + "px";
                    setTimeout(() => {
                        containerHeight.value = "fit-content";
                        if (navigator.userAgent.indexOf("Firefox") != -1)
                            containerHeight.value = "-moz-max-content";
                        container.value.style.overflow = "visible";
                    }, 300);
                });
            } else {
                containerHeight.value = container.value.scrollHeight + "px";
                container.value.style.overflow = "hidden";
                setTimeout(() => {
                    containerHeight.value = 0 + "px";
                }, 10);
                setTimeout(() => {
                    showChildren.value = false;
                }, 300);
            }
        };
        const route = useRoute();

        watch(route, (e) => {
            showChildren.value = false;
            expanded.value = false;
        });
        return {
            settings,
            route,
            toggleMenu,
            expanded,
            showChildren,
            container,
            containerHeight,
            itemToggleMenu,
            can
        };
    },
};
</script>
<style lang="scss" scoped>
.menu-item {
    cursor: pointer;

    .items-container {
        transition: height 0.3s ease;
    }

    .mdi-chevron-left.notranslate.v-icon,
    .mdi-chevron-down.notranslate.v-icon {
        margin-left: -15px !important;
    }
}

.notranslate.v-icon {
    margin-left: 7px !important;
}

.v-list-item__prepend>.v-icon {
    margin-inline-end: 10px !important;
    margin-left: 10px !important;
}
</style>
