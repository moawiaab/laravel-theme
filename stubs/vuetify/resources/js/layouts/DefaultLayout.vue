<template>
  <div class="">
    <v-app id="" :theme="settings.getTheme" class="fullscreen-wrapper">
      <v-layout ref="app" v-resize="settings.onResize">
        <v-system-bar>
          <v-btn
            variant="text"
            :prepend-icon="
              !settings.menu ? 'mdi-menu-open' : 'mdi-menu-right-outline'
            "
            @click="settings.setMenu"
            width="20"
            class="px-1"
          >
          </v-btn>

          <v-btn
            variant="text"
            :prepend-icon="
              settings.getTheme == 'light'
                ? 'mdi-weather-sunny'
                : 'mdi-weather-night'
            "
            @click="settings.setTheme"
            width="20"
            class="px-1"
          >
          </v-btn>

          <v-btn variant="text" :prepend-icon="wifi" />
          <v-icon>wifi</v-icon>

          <v-icon v-fullscreen.teleport="options" :icon="fullscreen"></v-icon>

          <v-spacer></v-spacer>
          <v-btn variant="text" prepend-icon="mdi-clock-outline">
            {{ formatDate(now, "hh:mm:ss") }}
          </v-btn>
          <v-btn variant="text" prepend-icon="mdi-calendar-range">
            {{ formatDate(now, "YYYY-MM-DD") }}
          </v-btn>
        </v-system-bar>
        <v-navigation-drawer
          v-model="settings.menu"
          class="pt-5"
          rail
          v-if="settings.window > 1280"
          rail-width="50"
        >
          <Dialog />
          <router-link
            v-for="(item, n) in sidebar.itemNav"
            :key="n"
            :to="item.url ?? ''"
          >
            <v-avatar
              :color="`purple-${
                route.path === item.url ? 'darken' : 'lighten'
              }-4`"
              size="30"
              class="d-block text-center mx-auto mb-5"
              :icon="item.icon"
            />
            <v-tooltip activator="parent" location="start">{{
              item.text
            }}</v-tooltip>
          </router-link>
        </v-navigation-drawer>
        <v-navigation-drawer v-model="settings.drawer" width="240">
          <!-- <v-row justify="end" v-if="settings.window < 1280">
                    <v-app-bar-nav-icon @click="settings.drawer = false" v-cloak>
                        <v-icon icon="mdi-close" />
                    </v-app-bar-nav-icon>
                </v-row> -->

          <v-list color="main-side">
            <v-list-subheader title="القائمةالجانبية"></v-list-subheader>
            <recursive-menu />
          </v-list>
        </v-navigation-drawer>
        <v-app-bar elevation="1" height="50">
          <v-app-bar-nav-icon @click="settings.setDrawer">
            <v-icon icon="mdi-menu" />
          </v-app-bar-nav-icon>
          <!-- <v-toolbar-title>اسم البرنامج <v-icon icon="mdi-keyboard-backspace"></v-icon> {{ router.name }}
                </v-toolbar-title> -->
          <v-toolbar-title />
          <v-menu>
            <template v-slot:activator="{ props }">
              <v-avatar size="36" class="text-center ml-4" v-bind="props">
                <v-icon icon="mdi-account-circle" size="34" />
              </v-avatar>
            </template>
            <v-list>
              <v-list-item
                v-for="(item, index) in sidebar.userList"
                :key="index"
                :value="index"
                variant="plain"
                class="text-right"
                @click="password.userMenuClicked(item)"
              >
                <template v-slot:prepend>
                  <v-icon :icon="item.icon"></v-icon>
                </template>

                <v-list-item-title>{{ item.text }}</v-list-item-title>
              </v-list-item>

              <v-list-item
                variant="plain"
                class="text-right"
                value="565"
                @click.prevent="settings.logout"
              >
                <template v-slot:prepend>
                  <v-icon icon="mdi-login-variant" />
                </template>
                <v-list-item-title>تسجيل خروج</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-app-bar>

        <v-main class="" scrollable>
          <v-container fill-height fluid>
            <Password />
            <v-snackbar
              v-model="alertData.snackbar"
              absolute
              text
              :color="alertData.color"
              close-on-content-click
              location="top"
            >
              {{ alertData.alert }}
            </v-snackbar>
            <router-view v-slot="{ Component, route }">
              <transition name="slide-x" mode="out-in">
                <component :is="Component" :key="route.path" />
              </transition>
            </router-view>
          </v-container>
        </v-main>
      </v-layout>
    </v-app>
  </div>
</template>

<script lang="ts">
import { directive as fullscreen } from "vue-fullscreen";
import { computed, onMounted, onUnmounted, watch, ref } from "vue";
import { useOnline, formatDate, useNow, useTitle } from "@vueuse/core";
import { useRoute } from "vue-router";
import { useSetting } from "../stores/settings/SettingIndex";
import { useSettingsItem } from "../stores/settings/SettingItem";
import { useSettingPassword } from "../stores/settings/SettingPassword";
import { useSettingAlert } from "../stores/settings/SettingAlert";
import Dialog from "../components/Dialog.vue";
import Password from "../components/dialog/Password.vue";
import RecursiveMenu from "../components/menu/Menu.vue";

export default {
  directives: { fullscreen },
  components: { Dialog, Password, RecursiveMenu },
  setup() {
    const settings = useSetting();
    const sidebar = useSettingsItem();
    const password = useSettingPassword();
    const now = useNow();
    const route = useRoute();

    const online = useOnline();
    const alertData = useSettingAlert();
    const wifi = computed(() =>
      online.value
        ? "mdi-wifi-arrow-left-right"
        : "mdi-wifi-strength-off-outline"
    );
    onMounted(() => sidebar.getRoles());
    onUnmounted(() => console.log("app onUnmounted"));
    useTitle(`اسم البرنامج | ${route.name?.toString()}`);
    watch(route, (e) => {
      useTitle(`اسم البرنامج | ${e.name?.toString()}`);
      // sidebar.getRoles()
    });

    const fullscreen = ref("mdi-fullscreen");

    const options = {
      target: ".fullscreen-wrapper",
      callback(isFullscreen: any) {
        fullscreen.value = isFullscreen
          ? "mdi-fullscreen-exit"
          : "mdi-fullscreen";
      },
    };
    return {
      fullscreen,
      options,
      settings,
      wifi,
      now,
      formatDate,
      route,
      sidebar,
      password,
      alertData,
    };
  },
};
</script>

<style>
.notranslate.v-icon {
  margin-left: 7px !important;
}

.v-list-item__prepend > .v-icon {
  margin-inline-end: 10px !important;
  margin-left: 10px !important;
}

.active-item-aside {
  background-color: #dfd4e9;
  border-radius: 5px !important;
}

/* v-slide-x-transition look a like */
.slide-x-enter-active,
.slide-x-leave-active {
  transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.5, 1), opacity 0.6s;
  opacity: 1;
  /* transition: opacity 1s transform 1s; */
}

.slide-x-enter-from,
.slide-x-leave-to {
  opacity: 0;
}

.slide-x-enter-from {
  transform: translateX(100px);
}

.slide-x-leave-to {
  transform: translateX(-100px);
}
</style>
