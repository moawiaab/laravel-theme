import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { useAccountIndex } from ".";
const route = "accounts";
export const useSingleAccounts = defineStore("single-accounts", {
    state: () => ({
        entry: {
            id: null,
            name: "",
            email: "",
            password: "",
            role_id: null,
            phone: "",
        },
        lists: {
            roles: [],
        },
        loading: false,
        errors: {
            id: null,
            name: null,
            email: null,
            password: null,
            role_id: null,
            phone: null,
        },
        showModalEdit: false,
        showModalShow: false,
    }),
    getters: {
        hasErrors: (state) => state.errors,
        // totalItem: (state) => state.total,
    },
    actions: {
        // send data to server in created
        storeData() {
            const accountIndex = useAccountIndex();
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, this.entry)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم إضافة الحساب بنجاح",
                            "success",
                            true
                        );
                        accountIndex.fetchIndexData();
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
        // send data to server in updated
        updateData() {
            this.loading = true;
            const accountIndex = useAccountIndex();
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${this.entry.id}`, this.entry)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم تعديل الحساب بنجاح",
                            "success",
                            true
                        );
                        accountIndex.fetchIndexData();
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

        //start in create
        fetchCreateData() {
            axios.get(`accounts/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },
        //start in edit
        fetchEditData(id: Number) {
            this.showModalEdit = false;
            axios.get(`${route}/${id}/edit`).then((response) => {
                this.entry = response.data.data;
                this.lists = response.data.meta;
            });
        },

        fetchShowData(id: Number) {
            this.showModalShow = false;
            axios.get(`${route}/${id}`).then((response) => {
                this.entry = response.data.data;
                // this.lists = response.data.meta;
            });
        },
    },
});
