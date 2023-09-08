<template>
    <div
        class="col"
        :class="`${$q.screen.xs ? 'col-xs-3 q-mb-sm full-width' : ''}`"
    >
        <q-card
            flat
            variant="tonal"
            :class="`q-pa-sm bg-${color}-1 full-width`"
        >
            <div class="row full-width">
                <div class="col q-pa-xs full-width">
                    <q-item-label :class="`q-mb-sm text-${color} text-bold `">
                        {{ $t(title) }}
                    </q-item-label>
                    <q-separator :color="color" />
                    <!-- <v-list-item-title class="mb-1"> {{title}} </v-list-item-title> -->
                    <q-item-label :class="`text-${color} text-bold `">
                        {{ text }}
                        <sub
                            ><small class="text-subtitle-2">{{
                                $t(subTitle)
                            }}</small></sub
                        >
                    </q-item-label>
                </div>
                <q-separator vertical :color="color" />
                <div class="col text-center">
                    <q-circular-progress
                        show-value
                        :value="iconText"
                        size="40px"
                        :thickness="0.4"
                        :color="color"
                        track-color="grey-3"
                        v-if="iconText"
                    >
                        {{ iconText }}%
                    </q-circular-progress>

                    <q-icon
                        v-else
                        :name="icon"
                        size="xl"
                        tag="span"
                        :color="color"
                    />
                </div>
            </div>
        </q-card>
    </div>
</template>

<script lang="ts">
export default {
    name: "ShowCard",
    props: ["title", "icon", "text", "color", "subTitle", "iconText"],
};
</script>
