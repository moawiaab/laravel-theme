import ar from 'quasar/lang/ar';
import en from 'quasar/lang/en-US'
import { defineStore } from "pinia";
import axios from "axios";
import type { LoginType, User } from "@/types";

import { Quasar } from "quasar";
import { useI18n } from 'vue-i18n'


export const useAuth = defineStore("auth-store", {
    state: () => ({
        entry: <LoginType>{},
        userData: <User | null>null,
        can: [],
        accounts : [],
        loading: false,
        splitterModel: 50,
        errors: {
            email: "",
            password: "",
        },
        quasarLang: ""
    }),
    getters: {
        user: (state) => state.userData
    },
    actions: {

        storeData(params: any) {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    // .post('login', this.entry)
                    .request({ baseURL: "/", url: "login", method: "post", params: params })
                    .then(async (response) => {
                        console.log(response.data)
                        await this.setRoles()
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })

                this.loading = false;

            });
        },
        setRoles() {
            axios.get("abilities").then((response) => {
                this.can = response.data.data
                this.userData = response.data.user;
            });
        },

        chingLang() {
            if (this.quasarLang === "en-US") {
                console.log(Quasar.lang.isoName)
                this.quasarLang = "ar"
                Quasar.lang.set(ar)
            } else if(this.quasarLang === "ar") {
                this.quasarLang = "en-US"
                Quasar.lang.set(en)
            }else{
                this.quasarLang = "en-US"
                Quasar.lang.set(en)
            }
        }

    },
    persist: true
});
