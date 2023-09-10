<template>
    <v-row no-gutters>
        <v-col>
            {{ title }}
        </v-col>
        <v-col :class="$vuetify.locale.current == 'ar' ? 'text-left' : 'text-right'">
            <v-chip color="primary" label class="ml-2">
                <v-icon start icon="mdi-plus-circle-outline"></v-icon>
                <slot />
            </v-chip>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: 'HeaderTitle',
    props: ['title']
}
</script>
