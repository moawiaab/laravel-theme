// Plugins
import vuetify from "./vuetify";
import VueHtmlToPaper from "./vueHtmlToPaper";
import { abilitiesPlugin } from "@casl/vue";
import ability from "../services/ability";
import router from "../router";
// Painia Settings
import { createPinia } from "pinia";
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate)

const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    timeout: 1000, // default timeout before the print window appears
    autoClose: true, // if false, the window will not close after printing
    windowTitle: window.document.title, // override the window title
};

import type { App } from "vue";

export function registerPlugins(app: App) {
    app.use(pinia);
    app.use(vuetify);
    app.use(abilitiesPlugin, ability, {
        useGlobalProperties: true,
    });
    app.use(router);
    app.use(VueHtmlToPaper, options);
}
