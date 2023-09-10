<template>
    <v-dialog max-width="380"  transition="dialog-bottom-transition">
        <template v-slot:activator="{ props }">
            <span color="primary" v-bind="props">
                <slot />
            </span>
        </template>

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col>{{ title }}</v-col>
                    <v-col class="text-left">
                        <v-icon icon="mdi-alert-circle-outline"></v-icon>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-divider />
            <v-card-text>
                {{ content }}
                <slot name="content" />
            </v-card-text>
            <v-divider />
            <v-card-actions>
                <v-spacer></v-spacer>
                <slot name="footer" />
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
export default {
    name: "DeleteItem",
    props: ['title', 'content'],
}
</script>

<style>

</style>
