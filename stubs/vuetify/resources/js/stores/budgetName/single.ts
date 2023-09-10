import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";

interface entryData {
    id: number | null;
    name: string;
    details: number;
    type: Number;
    status: number;
    created_at: string;
}

const route = "budget-names";
export const useSingleBudgetName = defineStore("single-budget-names", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            status: [],
            type: [],
        },
        loading: false,
        errors: {
            name: "",
            details: "",
            end_date: "",
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
                        usePageIndex().fetchIndexData();
                        useSettingAlert().setAlert(
                            "تم إضافة اسم الموازنة بنجاح",
                            "success",
                            true
                        );
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
                    });
                this.loading = false;
            });
        },
        // send data to server in updated
        updateData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${this.entry.id}`, this.entry)
                    .then((response) => {
                        usePageIndex().fetchIndexData();
                        useSettingAlert().setAlert(
                            "تم تعديل اسم الموازنة بنجاح",
                            "success",
                            true
                        );
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
                    });
                this.loading = false;
            });
        },

        setupEntry(entry: any, lists: any): void {
            this.entry = entry;
            this.lists = lists;
            // this.entry.type = 0;
        },
    },
});
