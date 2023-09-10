import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";
import { useRouter, useRoute } from "vue-router";
import { useSettingsItem } from "../settings/SettingItem";

interface entryData {
    id: Number | null;
    name: String;
    email: String;
    amount: Number;
    phone: String;
    password: String;
    roof: Number;
    status: Number;
    type: Number;
    user: String;
    created_at: String;
    terms : boolean
}

const route = "clients";
export const useSingleAuth = defineStore("single-auth", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            type: [],
            items: {
                data: [],
                total: 0,
            },
        },
        loading: false,
        showModalCreate: false,
        errors: {
            name: "",
            email: "",
            amount: "",
            password: "",
            phone: "",

        },
    }),
    getters: {
        hasErrors: (state) => state.errors,
    },
    actions: {
        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    // .post('login', this.entry)
                    .request({ baseURL: "/", url: "login", method: "post", params :  this.entry})
                    .then((response) => {
                        useSettingsItem().getRoles()
                        resolve(response);
                    })
                    .catch((error) => {
                        // this.errors = error.response.data.errors || this.errors;
                        // useSettingAlert().setAlert(
                        //     error.response.data.message,
                        //     "warning",
                        //     true
                        // );
                        reject(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },

        resetPassword() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    // .post('login', this.entry)
                    .request({ baseURL: "/", url: "forgot-password", method: "post", params :  this.entry})
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم إضافة المستخدم بنجاح",
                            "success",
                            true
                        );
                        // useRouter().push({name : 'dashboard'})
                        location.assign("/dashboard")
                        useSettingsItem().getRoles()
                        // usePageIndex().fetchIndexData();
                        // useSingleSupplierOrder().fetchCreateData();
                        // useSingleClientOrder().fetchCreateData();
                        // resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "warning",
                            true
                        );
                        reject(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        // send data to server in updated
        updateData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${this.entry.id}`, this.entry)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم تعديل المستخدم بنجاح",
                            "success",
                            true
                        );
                        usePageIndex().fetchIndexData();
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "warning",
                            true
                        );
                        reject(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },

        fetchCreateData() {
            axios.get(`${route}/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },
        setupEntry(entry: any, lists: any) {
            this.entry = entry;
            this.lists = lists;
        },
    },
});
