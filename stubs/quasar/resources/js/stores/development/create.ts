import { defineStore } from "pinia";
import axios from "axios";
import { Notify } from "quasar";
import { useTables } from "../tables";
import { useAuth } from "../auth/index";

const route = "/development-create";

export const useDevelopmentCreate = defineStore("development-create-store", {
    state: () => ({
        entry: {},
        lists: {},
        splitterModel: 30,
        loading: false,
    }),

    actions: {
        fetchData() {
            axios.get(`${route}`).then((response) => {
                this.lists = response.data.views;
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
                            type: "positive",
                        });
                        useTables().getData();
                        useTables().newRow = false;
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: "warning",
                        });
                        this.loading = false;
                        reject(error);
                    });
            });
        },

        removeItem(item: string, url : string) {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(`${route}/${url}`, { name: item })
                    .then((response) => {
                        Notify.create({
                            message: "Logout And Login To Show Change",
                            type: "positive",
                        });
                        // this.access()
                        console.log(response.data);
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: "warning",
                        });
                        this.loading = false;
                        reject(error);
                    });
            });
        },

        access() {
            axios
                .get("abilities")
                .then((res) => {
                    useAuth().can = res.data.data;
                    location.reload();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
});
