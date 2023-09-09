// FILE: main.js
import './bootstrap'
import { createApp } from 'vue'
import { Notify, Quasar } from 'quasar'
import quasarLangEn from 'quasar/lang/en-US'
import quasarLangAr from 'quasar/lang/ar'
import quasarIconSet from 'quasar/icon-set/mdi-v7'
// import '@quasar/extras/material-icons-outlined/index'
// import notify from 'quasar/src/plugins/Notify'
import { createI18n } from 'vue-i18n'


// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/mdi-v7/mdi-v7.css'

import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

// A few examples for animations from Animate.css:
import '@quasar/extras/animate/zoomIn.css'
import '@quasar/extras/animate/zoomOut.css'
// import '@quasar/extras/animate/rollOut.css'
// import '@quasar/extras/animate/rollIn.css'
import '@quasar/extras/animate/fadeIn.css'
// import '@quasar/extras/animate/fadeOutRight.css'
import '@quasar/extras/animate/fadeOut.css'

// Import Quasar css
import 'quasar/src/css/index.sass'
// import 'animate.css';
// import '../css/app.css'

import "../sass/custom.scss"

// Assumes your root component is App.vue
// and placed in same folder as main.js
import App from './App.vue'
import router from './router'

// Abilities Settings
// import { abilitiesPlugin } from "@casl/vue";
// import ability from "./services/ability";

import DataTable from "@/Components/tables/index.vue";
import fabs from "@/Components/buttons/Fab.vue";
import InputText from "@/Components/input/Text.vue"
import InputSelect from "@/Components/input/select.vue"
import WidgetsBar from "@/Components/Widgets/bar.vue"
import ItemLabel from "@/Components/item/label.vue"
import Loader from "@/Components/loader.vue"
import WidgetsShowCard from "@/Components/Widgets/ShowCard.vue"
import VueHtmlToPaper from "@/services/vueHtmlToPaper";



const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    timeout: 1000, // default timeout before the print window appears
    autoClose: true, // if false, the window will not close after printing
    windowTitle: window.document.title
};


const myApp = createApp(App)
myApp.use(router)
myApp.use(pinia)
myApp.use(VueHtmlToPaper, options);

import { useAuth } from './stores/auth'

let quasarLang = quasarLangEn
if (useAuth().quasarLang == "ar") {
    quasarLang = quasarLangAr
} else {
    useAuth().quasarLang = "en-US"
    quasarLang = quasarLangEn
}

import messages from './i18n'
// import messages from '@intlify/vite-plugin-vue-i18n/messages'
const i18n = createI18n({
    locale: useAuth().quasarLang,
    legacy : false,
    globalInjection: true,
    allowComposition: true,
    messages
})

// Tell app to use the I18n instance
myApp.use(i18n);

myApp.use(Quasar, {

    plugins: { Notify }, // import Quasar plugins and add here
    lang: quasarLang,
    iconSet: quasarIconSet,
    build: {
        rtl: true
    },
    animations: [
        'zoomIn',
    ],
    config: {
        notify: { position: "top" }
    }
})

// Assumes you have a <div id="app"></div> in your index.html

// myApp.use(abilitiesPlugin, ability, {
//     useGlobalProperties: true,
// });
myApp.component("DataTable", DataTable)
myApp.component("f-abs", fabs)
myApp.component("input-text", InputText)
myApp.component("input-select", InputSelect)
myApp.component("widgets-bar", WidgetsBar)
myApp.component("widgets-show-card", WidgetsShowCard)
myApp.component("item-label", ItemLabel)
myApp.component("loader", Loader)
myApp.mount('#app')



