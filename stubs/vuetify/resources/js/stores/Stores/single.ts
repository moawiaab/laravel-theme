import axios from "axios";
import { defineStore } from "pinia";
import { usePageIndex } from "../pages/pageIndex";
import { useSettingAlert } from "../settings/SettingAlert";
interface entryData {
    id: Number | null;
    name: String;
    details: String;
    products: Array<[]>;
}
const route = "stores";
export const useSingleStores = defineStore("single-stores", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            products: [],
        },
        loading: false,
        errors: {
            name: '',
            details: '',
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
                            "تم إضافة المخزن بنجاح",
                            "warning",
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
        // send data to server in updated
        updateData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${this.entry.id}`, this.entry)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم تعديل المخزن بنجاح",
                            "warning",
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

        setupEntry(entry: any, categories: any) {
            this.entry = entry;
            this.lists = categories
        },
    },
});
