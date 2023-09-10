import axios from "axios";
import { defineStore } from "pinia";
import { usePageIndex } from "../pages/pageIndex";
import { useSettingAlert } from "../settings/SettingAlert";
const route = "roles";
export const useSingleRoles = defineStore("single-roles", {
    state: () => ({
        entry: {
            id: null,
            title: "",
            permissions: [],
            users: [],
            created_at: null,
        },
        lists: {
            permissions: [],
            users: [],
        },
        loading: false,
        errors: {
            title: '',
            permissions: '',
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
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, this.entry)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم إضافة الصلاحية بنجاح",
                            "success",
                            true
                        );
                        this.loading = false;
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
                            "تم تعديل الصلاحية بنجاح",
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
                    })
            });
        },

        //start in create
        fetchCreateData() {
            axios.get(`${route}/create`).then((response) => {
                this.lists = response.data.meta;
                console.log(this.lists);
            });
        },
        //start in edit
        fetchEditData(id: Number) {
            this.showModalEdit = true;
            axios.get(`${route}/${id}/edit`).then((response) => {
                this.entry = response.data.data;
                this.lists = response.data.meta;
            });
        },

        fetchShowData(id: Number) {
            this.showModalShow = false;
            axios.get(`${route}/${id}`).then((response) => {
                this.entry = response.data.data;
                this.lists = response.data.meta;
            });
        },

        setData(enter:any, lists: any){
            this.entry = enter;
            this.lists = lists;
        }
    },
});
