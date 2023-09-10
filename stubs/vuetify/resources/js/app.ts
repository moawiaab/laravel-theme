import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import "./styles/app.scss";

import { registerPlugins } from '@/plugins'
import { defaultComponent } from '@/plugins/component'

const app = createApp(App);
registerPlugins(app)
defaultComponent(app)
app.mount("#app");
