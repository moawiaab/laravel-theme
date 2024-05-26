<template>
    <v-dialog v-model="model.showModalShow" max-width="1200" scrollable>
        <v-card>
            <v-card-title class="text-h5 text-primary">
                {{ $t("input.user.view") }} :
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-row>
                    <v-col cols="4">
                        <v-list-item>
                            <v-list-item-title>{{ single.entry.name }}</v-list-item-title>
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-account-outline"> الاسم</v-chip>
                            </template>
                        </v-list-item>

                    </v-col>
                    <v-divider vertical />
                    <v-col></v-col>
                </v-row>
            </v-card-text>
            <v-divider />
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                    @click="model.showModalShow = false">
                    {{ $t('g.close') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script lang="ts">
import { useSinglePage } from '../../stores/pages/pageSingle';
import { useSingleUsers } from '../../stores/users/single';

export default {
    name: "ShowUser",
    setup() {
        const single = useSingleUsers();
        const model = useSinglePage();
        single.setupEntry(model.entry, model.lists)
        return {
            single,
            model
        }
    },
}
</script>
