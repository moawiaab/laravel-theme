<template>
    <div
        class="w-50 ma-4"
        :class="{
            'has-items': query.s,
            'is-focused': focus,
        }"
    >
        <v-row>
            <v-col cols="9">
                <input
                    class="form-control"
                    type="search"
                    name="search"
                    :placeholder="$t('g.search')"
                    :value="query.s"
                    @input="debounceSearch($event.target.value)"
                    @focus="focus = true"
                    @blur="focus = false"
                />
            </v-col>
            <v-col class="text-left">
                <div class="" v-if="query.s.length !== 0" @click="query.s = ''">
                    <v-icon
                        icon="mdi-close"
                        color="red"
                        v-if="query.s.length !== 0"
                        @click="query.s = ''"
                    />
                </div>
            </v-col>
            <v-divider />
        </v-row>
    </div>
</template>

<script lang="ts">
export default {
    name: "SearchFilter",
    props: {
        query: { type: Object, require: true },
    },
    data() {
        return {
            focus: false,
        };
    },
    methods: {
        debounceSearch: _.debounce(function (value : any) {
            this.query.s = value;
            this.query.offset = 0;
        }, 300),
    },
};
</script>
<style scoped>
input {
    outline: none;
    width: 100%;
}
</style>
