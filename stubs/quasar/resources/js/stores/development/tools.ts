import { defineStore } from "pinia";
import axios from "axios";
import { Notify } from 'quasar';
import { useTables } from '../tables';

const route = "/development-tools";

export const useDevelopmentTool = defineStore("development-tools-store", {
    state: () => ({
        entry: {},
        lists: {},
        splitterModel : 30,
        loading: false,
    }),

    actions: {
        fetchData() {
            axios.get(`${route}`).then((response) => {
                this.lists = response.data;
            });
        },

        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, this.entry)
                    .then((response) => {
                        Notify.create({
                            message: "تم إضافة المستخدم بنجاح",
                            type: 'positive',

                        })
                        useTables().getData();
                        useTables().newRow = false
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        this.loading = false;
                        reject(error);
                    });
            });
        },
    }
});
