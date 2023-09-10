// Plugins
import VueHtmlToPaper from "./vueHtmlToPaper";
import { abilitiesPlugin } from "@casl/vue";
import ability from "../services/ability";
import router from "../router";
// Painia Settings


import { useSetting } from "../stores/settings/SettingIndex";

import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import { createVueI18nAdapter } from 'vuetify/locale/adapters/vue-i18n'
import { createVuetify } from "vuetify";
import { createI18n, useI18n } from "vue-i18n";
import messages from '../i18n'

const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    timeout: 1000, // default timeout before the print window appears
    autoClose: true, // if false, the window will not close after printing
    windowTitle: window.document.title, // override the window title
};

import type { App } from "vue";

// import { aliases, mdi } from "vuetify/iconsets/mdi";

const i18n =  createI18n({
    legacy: false, // Vuetify does not support the legacy mode of vue-i18n
    locale: "ar",
    fallbackLocale: "en",
    messages,
});

const vuetify = createVuetify({
    locale: {
        adapter: createVueI18nAdapter({ i18n, useI18n }),
    },
    defaults: {
        VTextField: {
            variant: "solo",
            clearable: true,
        },
        VTextarea: {
            variant: "solo",
            clearable: true,
        },
    },
});

export function registerPlugins(app: App) {
    app.use(i18n);
    app.use(vuetify);
    app.use(abilitiesPlugin, ability, {
        useGlobalProperties: true,
    });
    app.use(router);
    app.use(VueHtmlToPaper, options);

}
