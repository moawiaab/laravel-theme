<template>
    <v-btn :color="color ? `${color}-darken-1` : 'primary'" :prepend-icon="icon" variant="tonal" type="submit" :disabled="loading">
        <template v-slot:append v-if="loading">
            <v-progress-circular :size="20" :color="color" indeterminate></v-progress-circular>
        </template>
        {{ text }}
    </v-btn>
</template>

<script lang="ts">
export default {
    name:"BtnSave",
    props: {
        text: { type: String, default: "تنفيذ الأمر" },
        color: { type: String},
        icon: { type: String, default: "mdi-content-save-edit" },
        loading: { type: Boolean, default: false },
    }
}
</script>

<style>

</style>
