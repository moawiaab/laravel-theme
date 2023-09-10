import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import { createVuetify } from "vuetify";

// import { aliases, mdi } from "vuetify/iconsets/mdi";


export default createVuetify({
    locale : {
        locale : 'ar'
    },
    defaults: {
        VTextField: {
            variant: "solo",
            clearable: true
        },
        VTextarea : {
            variant: "solo",
            clearable: true
        },
    },
});
