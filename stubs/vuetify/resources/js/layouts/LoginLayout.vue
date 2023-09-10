<template>
    <v-app>
        <v-layout>
            <v-main>
                <!-- <v-card class="mx-auto mt-16" max-width="800">
                <v-row align="center">
                    <v-col class="mx-auto">
                        <v-img
                            :src="`/assets/images/login.png`"
                            class="align-end"
                        >
                        </v-img>
                    </v-col>
                    <v-divider vertical inset></v-divider>
                    <v-col>
                        <v-container>
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
                            <router-view />
                        </v-container>
                    </v-col>
                </v-row>
            </v-card> -->

                <v-card class="mx-auto mt-16" max-width="800">
                    <splitpanes
                        class="default-theme"
                        style="height: 100%"
                        :rtl="true"
                    >
                        <pane class="mx-auto">
                            <v-img
                                :src="`/assets/images/login.png`"
                                class="align-end"
                            >
                            </v-img>
                        </pane>
                        <pane>
                            <v-container>
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
                                <router-view />
                            </v-container>
                        </pane>
                    </splitpanes>
                </v-card>
            </v-main>
        </v-layout>
    </v-app>
</template>
<script lang="ts" setup>
import { useSettingAlert } from "../stores/settings/SettingAlert";
import { Splitpanes, Pane } from "splitpanes";

const alertData = useSettingAlert();
</script>
