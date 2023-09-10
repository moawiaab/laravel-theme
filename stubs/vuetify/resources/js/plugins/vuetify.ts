import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import { createVueI18nAdapter } from 'vuetify/locale/adapters/vue-i18n'
import { createVuetify } from "vuetify";
import { createI18n, useI18n } from "vue-i18n";
import messages from '../i18n'

// import { aliases, mdi } from "vuetify/iconsets/mdi";

const i18n =  createI18n({
    legacy: false, // Vuetify does not support the legacy mode of vue-i18n
    locale: "ar",
    fallbackLocale: "en",
    messages,
});

export default createVuetify({
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
