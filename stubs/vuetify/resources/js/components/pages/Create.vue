<template>
    <v-btn variant="text" @click="single.showModalCreate = true"> إضافة</v-btn>
    <v-dialog v-model="single.showModalCreate" persistent max-width="800" scrollable>
        <slot />
    </v-dialog>
</template>

<script lang="ts">
import { useSinglePage } from '../../stores/pages/pageSingle';

export default {
    name: "CreatePage",
    setup() {
        const single = useSinglePage()
        return {
            single
        }
    },

}
</script>
