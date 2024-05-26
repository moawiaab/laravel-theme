import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";

interface entryData {
    id: Number | null;
    name: String;
    email: String;
    password: String;
    phone: String;
    role: String;
    role_id: Number;
    password_confirmation: String;
}

const route = "users";
export const useSingleUsers = defineStore("single-users", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            roles: [],
        },
        loading: false,
        errors: {
            name: "",
            email: "",
            password: "",
            role_id: "",
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
                    .post(route, this.entry)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم إضافة المستخدم بنجاح",
                            "success",
                            true
                        );
                        usePageIndex().fetchIndexData();
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "warning",
                            true
                        );
                        this.loading = false;
                        reject(error);
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
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "warning",
                            true
                        );
                        this.loading = false;
                        reject(error);
                    });
            });
        },

        setupEntry(entry: any, lists: any) {
            this.entry = entry;
            this.lists = lists;
        },
    },
});
