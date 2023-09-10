import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import "./styles/app.scss";

import { registerPlugins } from "@/plugins";
import { defaultComponent } from "@/plugins/component";

import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const app = createApp(App);
app.use(pinia);
registerPlugins(app);
defaultComponent(app);
app.mount("#app");
