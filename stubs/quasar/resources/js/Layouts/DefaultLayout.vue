<template>
    <!-- <div class=""> -->
    <q-layout
        view="lhH LpR lff"
        container
        style="height: 100vh"
        class="bg-white"

    >
        <q-header class="bg-white text-primary" bordered>
            <q-toolbar>
                <q-btn
                    flat
                    dense
                    round
                    icon="menu"
                    aria-label="Menu"
                    @click="drawerLeft = !drawerLeft"
                />

                <q-toolbar-title> {{$t('app_title')}} </q-toolbar-title>

                <q-btn flat icon="mdi-translate" dense fab-mini @click="auth.chingLang(); $i18n.locale = auth.quasarLang"/>
                <q-btn flat icon="notifications" dense fab-mini />

                <q-btn flat dense fab-mini round>
                    <q-avatar>
                        <q-img src="/img/logo.png" />
                    </q-avatar>
                    <q-menu transition-show="rotate" transition-hide="rotate">
                        <q-list style="min-width: 200px" separator>
                            <menu-icon
                                text="g.m.profile"
                                icon="mdi-account"
                                to="/about"
                                color="blue"
                                :disable="true"
                            />
                            <menu-icon
                                text="g.m.password"
                                icon="password"
                                @click="settings.password = true"
                                v-close-popup
                            />
                            <menu-icon
                                text="g.m.setting"
                                icon="settings"
                                color="green"
                                to="/settings"
                            />
                            <menu-icon
                                text="g.logout"
                                icon="logout"
                                color="red"
                                @click="logout"
                            />
                        </q-list>
                    </q-menu>
                </q-btn>
            </q-toolbar>
        </q-header>
        <q-drawer
            v-model="drawerLeft"
            show-if-above
            bordered
            :width="260"
            v-if="auth.userData"
        >
            <div
                class="row justify-center q-px-md q-pt-md fixed-top"
                style="background: #ecf8fe; z-index: 8; height: 192px"
            >
                <q-avatar size="100px" style="border: 2px solid #f0f0f0">
                    <q-img src="/img/logo.png" width="100px" height="100px" />
                </q-avatar>
                <q-item class="bg-light-blue-1 q-pt-sm" disable dense>
                    <q-item-section class="q-pa-sm">
                        <q-item-label>
                            {{$t('g.email_greet')}} : {{ auth.userData.name }}</q-item-label
                        >
                        <q-item-label caption>
                            <q-item-section>
                                {{$t('g.email')}} : {{ auth.userData.email }}
                            </q-item-section>
                            {{$t('g.phone')}} : {{ auth.userData.phone }}
                        </q-item-label>
                    </q-item-section>
                </q-item>
            </div>
            <q-separator />

            <q-list separator class="q-mb-xl" style="padding-top: 195px">
                <list-menu />
            </q-list>
            <q-item
                v-ripple
                class="text-red footer bg-white full-width fixed-bottom"
                clickable
                @click="logout"
            >
                <q-item-section avatar>
                    <q-icon name="logout" />
                </q-item-section>

                <q-item-section> {{$t('g.logout')}}</q-item-section>
            </q-item>
        </q-drawer>
        <q-page-container>
            <!-- <q-page> -->
            <router-view v-slot="{ Component }">
                <transition
                    appear
                    enter-active-class="animated zoomIn"
                    leave-active-class="animated zoomOut"
                    mode="out-in"
                >
                    <component :is="Component" />
                </transition>
            </router-view>
            <!-- </q-page> -->

            <q-page-scroller position="bottom-right">
                <q-btn
                    fab
                    icon="keyboard_arrow_up"
                    color="primary"
                    class="glossy"
                />
            </q-page-scroller>
        </q-page-container>
        <settings-password />
    </q-layout>
    <!-- </div> -->
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { Platform, Screen } from "quasar";
import ListMenu from "@/Components/menu/ListMenu.vue";
import MenuIcon from "@/Components/menu/icon.vue";
import SettingsPassword from "@/Components/settings/password.vue";
import { useAuth } from "@/stores/auth/index";

import { useSettings } from "@/stores/settings";

const settings = useSettings();
const auth = useAuth();

const drawerLeft = ref(Screen.width > 702 ? true : false);

const logout = () => {
    axios
        .request({
            baseURL: "/",
            url: "logout",
            method: "post",
        })
        .then(() => {
            console.log("logged out");
            location.reload();
        })
        .catch(() => {});
};

</script>
