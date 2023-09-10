<template>
    <v-app>
        <v-layout>
            <v-main>
                <v-card width="80%" class="mx-auto" height="600" flat>
                    <v-card-title>
                        <v-list-item
                            prepend-icon="mdi-home"
                            title="رجوع الى الصفحة الرئيسية"
                            to="/dashboard"
                        />
                    </v-card-title>
                    <v-img
                        :src="`/assets/images/notfound.png`"
                        class="align-end"
                    >
                    </v-img>
                </v-card>
            </v-main>
        </v-layout>
    </v-app>
</template>
<script lang="ts" setup></script>

<style></style>
