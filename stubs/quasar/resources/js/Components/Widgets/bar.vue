<script lang="ts" setup>
import { useSettings } from "@/stores/settings";
const settings = useSettings();
</script>

<template>
    <q-bar class="">
        <q-space />
        <q-btn
            dense
            flat
            icon="minimize"
            @click="settings.maximizedToggle = false"
            :disable="!settings.maximizedToggle"
        >
            <q-tooltip
                v-if="settings.maximizedToggle"
                class="bg-white text-primary"
                >
 {{$t('g.min')}}
                </q-tooltip
            >
        </q-btn>
        <q-btn
            dense
            flat
            icon="crop_square"
            @click="settings.maximizedToggle = true"
            :disable="settings.maximizedToggle"
        >
            <q-tooltip
                v-if="!settings.maximizedToggle"
                class="bg-white text-primary"
                >
                {{$t('g.max')}}
                </q-tooltip
            >
        </q-btn>
        <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">
                {{$t('g.close')}}
            </q-tooltip>
        </q-btn>
    </q-bar>
</template>

<style scoped></style>
