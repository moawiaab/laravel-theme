<template>
    <v-card variant="tonal" :color="color">
        <v-row align="end" class="px-2">
            <v-col>
                <v-list-item-title class="mb-1"> {{title}} </v-list-item-title>
                <v-divider :color="color" />
                <h1>{{text}} <sub><small class="text-subtitle-2">{{subTitle}}</small></sub></h1>
            </v-col>
            <v-divider vertical :color="color"/>
            <v-col class="text-center">
                <v-icon
                    :icon="icon"
                    size="80"
                    tag="span"
                />
            </v-col>
        </v-row>
    </v-card>
</template>

<script lang="ts">
export default {
    name : 'ShowCard',
    props: ['title', 'icon', 'text', 'color', 'subTitle']
}
</script>
