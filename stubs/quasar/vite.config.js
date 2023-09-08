import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { quasar, transformAssetUrls } from "@quasar/vite-plugin";
import VueI18nPlugin from "@intlify/unplugin-vue-i18n";

import { resolve } from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        quasar({
            sassVariables: "resources/sass/quasar-variables.sass",
        }),
        // VueI18nPlugin({
        //     include: resolve(__dirname, "resources/js/i18n/index.ts"),
        // }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": resolve(__dirname, "resources/js/"),
            "@@": resolve(__dirname, "resources/js/Components/page/"),
        },
    },
});
